@extends('layouts.exam')
@section('content')
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <a class="navbar-brand mr-auto mr-lg-0" href="#">TDIU Exam</a>
    </nav>

    <main role="main" class="container pb-5">
        <div class="my-3 p-3 text-center">
            <h3 class="">TOSHKENT DAVLAT IQTISODIYOT UNIVERSITETI
                MAGISTRATURA MUTAXASSISLIKLARI BO’YICHA QABUL KOMISSIYASI
            </h3>

            <br /><br />
            <h2 class="text-primary font-weight-bold">INGLIZ TILIDAN TEST SINOVLARI</h2>
            <h2 class="text-primary font-weight-bold">ТЕСТЫ ПО АНГЛИЙСКОМУ ЯЗЫКУ</h2>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card rounded shadow-sm">

                        <div class="card-body">
                            <form action="{{ route('exam.login') }}" method="post">
                                @csrf

                                <div class="form-group row">
                                    <label for="login" class="col-md-4 col-form-label text-md-right">Логин</label>

                                    <div class="col-md-6">
                                        <input id="login" type="text" class="form-control" name="login" required  autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-success">
                                            Войти
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection