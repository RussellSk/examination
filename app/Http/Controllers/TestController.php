<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Test;
use Illuminate\Http\Request;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Список добавленных тестов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.tests.index', ['tests' => Test::orderBy('id', 'ASC')->paginate(25)]);
    }

    /**
     * Отобразить форму импорта файла XML
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadShow()
    {
        return view('pages.tests.upload', ['languages' => Language::all()]);
    }

    /**
     * Импортирование файла тестов
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->hasFile('xlsfile')) {
            try {
                $file = $request->file('xlsfile');
                $filename = 'xt_'.md5(time()).'.'.$file->getClientOriginalExtension();
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

                Test::where('language_id', $request->input('language'))->delete();

                for ($i = 2; $i <= $rowsNumber; $i++) {
                    $test = new Test();
                    $test->question = $sheet->getCell('A'.$i)->getValue();
                    $test->option_a = $sheet->getCell('B'.$i)->getValue();
                    $test->option_b = $sheet->getCell('C'.$i)->getValue();
                    $test->option_c = $sheet->getCell('D'.$i)->getValue();
                    $test->option_d = $sheet->getCell('E'.$i)->getValue();
                    $test->	answer = trim($sheet->getCell('F'.$i)->getValue());
                    $test->language_id = $request->input('language');
                    $test->save();
                }

                @unlink($filePath);

            } catch (Exception $ex) {
                return redirect()->back()->with('flash_error', 'Ошибка импорта файла: '.$ex->getMessage());
            }

            return redirect()->back()->with('flash_success', 'Тесты успешно импортированы');
        }

        return redirect()->back();
    }

    /**
     * Отобразить форму редактирования теста
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('pages.tests.edit', ['test' => Test::findOrFail($id), 'languages' => Language::all()]);
    }

    /**
     * Сохранение информации о тесте
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        try {
            $test = Test::findOrFail($id);
            $test->question = $request->input('question');
            $test->option_a = $request->input('option_a');
            $test->option_b = $request->input('option_b');
            $test->option_c = $request->input('option_c');
            $test->option_d = $request->input('option_d');
            $test->	answer = trim($request->input('answer'));
            $test->language_id = $request->input('language');
            $test->save();

        } catch (Exception $ex) {
            return redirect()->back()->with('flash_error', 'Ошибка сохранения информации: '.$ex->getMessage());
        }

        return redirect()->back()->with('flash_success', 'Информация успешно обновлена');
    }

    /**
     * Удаление теста
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            $test = Test::findOrFail($id);
            $test->delete();
        } catch (Exception $ex) {
            return redirect()->back()->with('flash_error', 'Ошибка удаления теста: '.$ex->getMessage());
        }

        return redirect()->back()->with('flash_success', 'Тест удален успешно');
    }
}
