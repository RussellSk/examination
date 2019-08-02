<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Student;
use Illuminate\Http\Request;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Отображение главной страницы импорта юзеров
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $students = Student::orderBy('id', 'ASC')->paginate(25);
        return view('pages.users.index', ['students' => $students]);
    }

    /**
     * Отображение страницы импорта XLS файла
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadShow()
    {
        return view('pages.users.upload');
    }

    /**
     * Импорт студента из файла XLS
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadFile(Request $request)
    {
        if ($request->hasFile('xlsfile')) {
            try {
                $file = $request->file('xlsfile');
                $filename = 'x_'.md5(time()).'.'.$file->getClientOriginalExtension();
                $file->storeAs('/public/files/', $filename);
                $filePath = storage_path('/app/public/files/'.$filename);

                $xls = new Xlsx();
                if (!$xls->canRead($filePath))
                    throw new Exception('Невозможно прочитать файл: '.$filePath);

                $reader = IOFactory::createReaderForFile($filePath);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($filePath);
                $sheet = $spreadsheet->getActiveSheet();
                $rowsNumber = $sheet->getHighestRow();

                Student::truncate();

                for ($i = 2; $i <= $rowsNumber; $i++) {
                    $student = new Student();
                    $student->name = $sheet->getCell('A'.$i)->getValue();
                    $student->code = $sheet->getCell('B'.$i)->getValue();
                    $student->language_id = (int)$sheet->getCell('C'.$i)->getValue();
                    $student->save();
                }

                @unlink($filePath);

            } catch (Exception $ex) {
                return redirect()->back()->with('flash_error', 'Ошибка импорта данных: '.$ex->getMessage());
            }

            return redirect()->back()->with('flash_success', 'Данные успешно импортированны');
        }

        return redirect()->back();
    }

    /**
     * Отображение формы редактирования студента
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('pages.users.edit', ['student' => Student::findOrFail($id), 'languages' => Language::all()]);
    }

    /**
     * Сохранение информации студента
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        try {
            $student = Student::findOrFail($id);
            $student->name = $request->input('name');
            $student->code = $request->input('code');
            $student->enter_code = $request->input('enter_code');
            $student->enter_password = $request->input('enter_password');
            $student->language_id = (int)$request->input('language');
            $student->save();
        } catch (Exception $ex) {
            return redirect()->back()->with('flash_error', 'Ошибка сохранения данныех: '.$ex->getMessage());
        }

        return redirect()->back()->with('flash_success', 'Информация успешно обновлена');
    }

    /**
     * Удаление студента
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
        } catch (Exception $ex) {
            return redirect()->back()->with('flash_error', 'Ошибка удаления студента: '.$ex->getMessage());
        }

        return redirect()->back()->with('flash_error', 'Студент успешно удален');
    }

    /**
     * Генерация доступов для студентов
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateAccess()
    {
        $students = Student::all();
        foreach ($students as $student) {
            $fillerEnterCode = hexdec(uniqid($student->id));
            $fillerPassword = uniqid($student->id);
            $idCount = strlen((string)$student->id);
            $student->enter_code = substr($fillerEnterCode, 0, 7 - $idCount).(string)$student->id;
            $student->enter_password = substr($fillerPassword, 0, 7 - $idCount).(string)$student->id;;
            $student->save();
        }

        return redirect()->back()->with('flash_success', 'Доступы успешно сгенерированны');
    }

    /**
     * Распечатать доступы для студентов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printAccess()
    {
        return view('pages.users.print', ['students' => Student::all()]);
    }

}
