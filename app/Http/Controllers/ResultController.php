<?php

namespace App\Http\Controllers;

use App\Models\ResultAnswer;
use App\Models\Results;
use App\Models\Student;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Отобразить результаты экзаменов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.results.index', ['results' => Results::orderBy('id', 'DESC')->paginate(25)]);
    }

    /**
     * Отобразить детальный результат по студентам
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        $result = Results::findOrFail($id);
        return view('pages.results.show', ['result' => $result]);
    }

    /**
     * Форма редактирования
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('pages.results.edit', ['result' => Results::findOrFail($id)]);
    }

    /**
     * Сохранение информации
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($id, Request $request)
    {
        try {
            $result = Results::findOrFail($id);
            $result->total_answers = $request->input('total_answers');
            $result->total_given_answers = $request->input('total_given_answers');
            $result->wrong_answers = $request->input('wrong_answers');
            $result->right_answers = $request->input('right_answers');
            $result->save();

            $question_id = $request->input('question_id');
            $answer_id = $request->input('answer_id');
            $answer_option = $request->input('answer_option');

            for ($i = 0; $i < count($question_id); $i++) {
                if (($answer = ResultAnswer::find($answer_id[$i])) !== null) {
                    $answer->answer_given = trim($answer_option[$i]);
                    $answer->save();
                }
            }

        } catch (Exception $ex) {
            return redirect()->back()->with('flash_error', 'Ошибка сохранения данных: '.$ex->getMessage());
        }

        return redirect()->back()->with('flash_success', 'Данные успешно сохранены');
    }

    /**
     * Экспорт результатов в XLS
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportXLS()
    {
        try {

            $students = Student::all();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Шифр');
            $sheet->setCellValue('B1', 'ФИО');
            $sheet->setCellValue('C1', 'Язык');
            $sheet->setCellValue('D1', 'Всего вопросов');
            $sheet->setCellValue('E1', 'Количество решивших');
            $sheet->setCellValue('F1', 'Правильных');
            $sheet->setCellValue('G1', 'Не правильных');

            $index = 2;
            foreach ($students as $student) {
                $sheet->setCellValue('A'.$index, $student->code);
                $sheet->setCellValue('B'.$index, $student->name);
                $sheet->setCellValue('C'.$index, $student->language->name ?? '');
                if ($student->hasResult()) {
                    $sheet->setCellValue('D' . $index, $student->result->total_answers ?? '');
                    $sheet->setCellValue('E' . $index, $student->result->total_given_answers ?? '');
                    $sheet->setCellValue('F' . $index, $student->result->right_answers ?? '');
                    $sheet->setCellValue('G' . $index, $student->result->wrong_answers ?? '');
                } else {
                    $sheet->setCellValue('D' . $index, '0');
                    $sheet->setCellValue('E' . $index, '0');
                    $sheet->setCellValue('F' . $index, '0');
                    $sheet->setCellValue('G' . $index, '0');
                }
                $index++;
            }

            $fileName = public_path().'/download/export_results.xlsx';

            $writer = new Xlsx($spreadsheet);
            $writer->save($fileName);

            return response()->download($fileName);

        } catch (Exception $ex) {
            return redirect()->back()->with('flash_error', 'Ошибка выгрузки данных: '.$ex->getMessage());
        }

    }
}
