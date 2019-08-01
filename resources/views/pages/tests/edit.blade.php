@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Редактирование теста</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Редактирование теста: {{ $test->question }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tests.update', $test->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="language" class="col-sm-2 col-form-label">Язык</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="language" id="language">
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}" {{ $language->id == $test->language_id ? 'SELECTED' : '' }}>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="question" class="col-sm-2 col-form-label">Вопрос</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="question" id="question" value="{{ $test->question }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="option_a" class="col-sm-2 col-form-label">Вариант А</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="option_a" id="option_a">{{ $test->option_a }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="option_b" class="col-sm-2 col-form-label">Вариант B</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="option_b" id="option_b">{{ $test->option_b }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="option_c" class="col-sm-2 col-form-label">Вариант C</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="option_c" id="option_c">{{ $test->option_c }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="option_d" class="col-sm-2 col-form-label">Вариант D</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="option_d" id="option_d">{{ $test->option_d }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="answer" class="col-sm-2 col-form-label">Ответ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="answer" id="answer" value="{{ $test->answer }}">
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body bg-light p-2">
                                <input type="submit" class="btn btn-success mr-3" name="save" value="Сохранить">
                                <a href="{{ route('importUsers') }}" class="btn btn-primary mr-3">Отмена</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection