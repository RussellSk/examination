@extends('layouts.exam')
@section('content')
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <a class="navbar-brand mr-auto mr-lg-0" href="#">Exam 1.0</a>
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
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Логин</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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