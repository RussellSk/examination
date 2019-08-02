<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Exception;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('pages.language.index', ['languages' => Language::orderBy('id', 'DESC')->get()]);
    }

    public function store(Request $request)
    {
        try {
            $language = new Language();
            $language->name = $request->input('name');
            $language->save();
        } catch (Exception $ex) {
            return redirect()->back()->with('flash_error', 'Ошибка добавления языка: '.$ex->getMessage());
        }
        return redirect()->back()->with('flash_success', 'Язык успешно добавлен');
    }

    public function delete($id)
    {
        try {
            $language = Language::findOrFail($id);
            $language->delete();
        } catch (Exception $ex) {
            return redirect()->back()->with('flash_error', 'Ошибка удаления языка: '.$ex->getMessage());
        }

        return redirect()->back()->with('flash_success', 'Язык успешно удален');
    }
}
