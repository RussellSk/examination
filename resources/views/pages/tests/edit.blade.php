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
                    <form action="{{ route('student.update', $student->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Имя</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" value="{{ $student->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">Шифр</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="code" id="code" value="{{ $student->code }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="enter_code" class="col-sm-2 col-form-label">Логин входа</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="enter_code" id="enter_code" value="{{ $student->enter_code }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="enter_password" class="col-sm-2 col-form-label">Пароль входа</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="enter_password" id="enter_password" value="{{ $student->enter_password }}">
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