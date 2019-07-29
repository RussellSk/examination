@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Добавление пользователямя</h1>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm mb-3">Добавить пользователя</a>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Форма добавления пользователя</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email" >Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Подтверждение пароля</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>

                        <input type="submit" class="btn btn-primary" value="Добавить">

                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection