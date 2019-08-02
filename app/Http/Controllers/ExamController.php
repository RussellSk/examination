<?php

namespace App\Http\Controllers;

use App\Models\ResultAnswer;
use App\Models\Results;
use App\Models\Student;
use App\Models\Test;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{
    /**
     * Страница с тестированием, загрузка приложения front-end VUE.js
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (!Session::has('student')) {
            return redirect()->route('exam.main');
        }

        if (!Session::has('endTime')) {
            Session::put('endTime', Carbon::now("Asia/Tashkent")->addHour());
        }

        return view('pages.students.exam.index', ['endTime' => Session::get('endTime')]);
    }

    /**
     * Страница информации
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info()
    {
        if (!Session::has('student')) {
            return redirect()->route('exam.main')->with('flash_error', 'Вы не авторизованы, пожалуйста войдите в систему');
        }
        return view('pages.students.exam.info');
    }

    /**
     * Страница входа студентов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        if (Session::has('result-data')) {
            Session::forget('result-data');
        }

        if (Session::has('student')) {
            Session::forget('student');
        }

        if (Session::has('endTime')) {
            Session::forget('endTime');
        }


        return view('pages.students.exam.login');
    }

    /**
     * Авторизация студента в системе
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLogin(Request $request)
    {
        if (!$request->has('login')) {
            return redirect()->back()->with('flash_error', 'Вы ввели неверный логин');
        }

        if (!$request->has('password')) {
            return redirect()->back()->with('flash_error', 'Вы ввели неверный пароль');
        }

        $student = Student::where('enter_code', $request->input('login'))->where('enter_password', $request->input('password'))->first();

        if ($student == null) {
            return redirect()->back()->with('flash_error', 'Вы ввели неверный логин или пароль');
        }

        if ($student->attended) {
            return redirect()->back()->with('flash_error', 'Вы уже сдали экзамен');
        }

        Session::put('student', [
            'id' => $student->id,
            'name' => $student->name,
            'language_id' => $student->language_id,
        ]);

        return redirect()->route('exam.info');
    }

    /**
     * Отобразить страницу результатов
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function resultPage()
    {
        if (Session::has('student')) {
            Session::forget('student');
        }

        if (!Session::has('result-data')) {
            return redirect()->route('exam.main');
        }

        return view('pages.students.exam.result', ['results' => Session::get('result-data')]);
    }

    /**
     * Возвращает данные вопросов тестирования
     * @return \Illuminate\Http\JsonResponse
     */
    public function questionDataJSON()
    {
        if (!Session::has('student'))
            return response()->json(['message' => 'Not authorized']);

        $studentSession = Session::get('student');

        $data = [];
        $questions = DB::select(DB::raw('SELECT * FROM tests WHERE language_id = :language_id ORDER BY RAND() LIMIT 50'), [
            'language_id' => $studentSession['language_id']
        ]);

        foreach ($questions as $question) {
            $data []= [
                'id' => $question->id,
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

    /**
     * AJAX функция обрабатывает результаты экзамена
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function finishExam(Request $request)
    {
        if (!Session::has('student'))
            return response()->json(['message' => 'Already done']);

        $data = [];
        try {
            $data = json_decode($request->getContent(), true);
            if ($data == null)
                throw new Exception("The given data must be a valid.");
        } catch (Exception $ex) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    $ex->getMessage(),
                ]
            ], 422);
        }

        if (Session::has('student'))
            $studentSession = Session::get('student');

        $user_id = Arr::get($studentSession, 'id');
        $language_id = Arr::get($studentSession, 'language_id');

        $result = new Results();
        $result->student_id = $user_id;
        $result->save();

        $totalCorrectAnswers = 0;
        $totalIncorretAnswers = 0;
        $totalGivenAnswers = 0;

        foreach ($data as $item) {
            if (($test = Test::find(Arr::get($item, 'id'))) !== null) {
                if (!empty(Arr::get($item, 'userAnswer'))) {
                    $resultAnswer = new ResultAnswer();
                    $resultAnswer->result_id = $result->id;
                    $resultAnswer->user_id = $user_id;
                    $resultAnswer->question_id = $test->id;
                    $resultAnswer->answer_given = Arr::get($item, 'userAnswer');
                    $resultAnswer->save();
                    $totalGivenAnswers++;
                    if ($test->	answer == Arr::get($item, 'userAnswer')) {
                        $totalCorrectAnswers++;
                    } else {
                        $totalIncorretAnswers++;
                    }
                }
            }
        }

        $result = new Results();
        $result->student_id = $user_id;
        $result->total_answers = 50;
        $result->total_given_answers = $totalGivenAnswers;
        $result->wrong_answers = $totalIncorretAnswers;
        $result->right_answers = $totalCorrectAnswers;
        $result->save();

        $student = Student::find($user_id);
        $student->attended = true;
        $student->save();

        Session::put('result-data', [
            'total_answers' => $result->total_answers,
            'total_given_answers' => $result->total_given_answers,
            'wrong_answers' => $result->wrong_answers,
            'right_answers' => $result->right_answers,
            'student_name' => $student->name,
        ]);

        Session::forget('student');

        return response()->json(['message' => 'Processed successfully']);
    }
}
