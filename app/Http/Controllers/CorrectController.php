<?php

namespace App\Http\Controllers;

use App\Models\Correct;
use Illuminate\Http\Request;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class CorrectController extends Controller
{
    /**
     * Список правильных результатов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.correct.index', ['results' => Correct::orderBy('id', 'DESC')->paginate(25)]);
    }

    /**
     * Страница импортирования файла XLS
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import()
    {
        return view('pages.correct.import');
    }

    /**
     * Обработка импортируемого файла XLS
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleImport(Request $request)
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

                Correct::truncate();

                for ($i = 2; $i <= $rowsNumber; $i++) {
                    $student = new Correct();
                    $student->student_code = $sheet->getCell('B'.$i)->getValue();
                    $student->total_answers = $sheet->getCell('C'.$i)->getValue();
                    $student->given_answers = (int)$sheet->getCell('D'.$i)->getValue();
                    $student->right_answers = (int)$sheet->getCell('E'.$i)->getValue();
                    $student->wrong_answers = (int)$sheet->getCell('F'.$i)->getValue();
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
}
