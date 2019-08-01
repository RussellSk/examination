<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Страница с тестированием, загрузка приложения front-end VUE.js
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.students.exam.index');
    }

    /**
     * Страница информации
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info()
    {
        return view('pages.students.exam.info');
    }

    /**
     * Страница входа студентов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('pages.students.exam.login');
    }

    /**
     * Возвращает данные вопросов тестирования
     * @return \Illuminate\Http\JsonResponse
     */
    public function questionDataJSON()
    {
        $data = [];
        $questions = Test::where('language_id', 3)->get();
        foreach ($questions as $question) {
            $data []= [
                'question' => $question->question,
                'userAnswer' => '',
                'answers' => [
                    $question->option_a,
                    $question->option_b,
                    $question->option_c,
                    $question->option_d,
                ]
            ];
        }

        return response()->json($data);
    }

    public function finishExam()
    {

    }
}
