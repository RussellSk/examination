<?php

namespace App\Http\Controllers;

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
}
