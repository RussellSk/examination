@extends('layouts.exam')
@section('content')
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <a class="navbar-brand mr-auto mr-lg-0" href="#">TDIU Exam</a>
    </nav>

    <main role="main" class="container pb-5">
        <div class="my-3 p-3 bg-white rounded shadow-sm text-center">
            <h2 class="text-primary">TEST YAKUNLANDI! ТЕСТ ОКОНЧЕН!</h2>
            <hr />
            <h2 class="text-primary font-weight-bold">{{ $results['total_answers'] }}/{{ $results['right_answers'] }}</h2>
            <h2>{{ round(($results['right_answers'] / $results['total_answers']) * 100) }}%</h2>
            <h2>Siz - <strong class="text-success">{{ $results['right_answers'] }}</strong> ball to’pladingiz</h2>
            <h2>Вы набрали <strong class="text-success">{{ $results['right_answers'] }} баллов</strong></h2>
        </div>

        <table class="table table-bordered table-hover bg-white rounded shadow-sm font-weight-bold" style="font-size: 20px!important;">
            <tr>
                <td>Всего вопросов</td>
                <td>{{ $results['total_answers'] }}</td>
            </tr>
            <tr>
                <td>Вы ответили</td>
                <td>{{ $results['total_given_answers'] }}</td>
            </tr>
            <tr>
                <td>Правильных ответов</td>
                <td>{{ $results['right_answers'] }}</td>
            </tr>
            <tr>
                <td>Неправильных ответов</td>
                <td>{{ $results['wrong_answers'] }}</td>
            </tr>
        </table>
        <div class="text-center">
            <a href="{{ route('exam.main') }}" class="btn btn-success btn-lg shadow font-weight-bold" style="width: 150px">Exit</a>
        </div>
    </main>
@endsection