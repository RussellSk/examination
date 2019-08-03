@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Детализация результата</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Детализация результата по студенту: <strong>{{ $result->student->name ?? '' }}</strong></h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-sm font-weight-bold">
                        <tr>
                            <td>Всего вопросов</td>
                            <td>{{ $result->total_answers }}</td>
                        </tr>
                        <tr>
                            <td>Ответил на вопросы</td>
                            <td>{{ $result->total_given_answers }}</td>
                        </tr>
                        <tr>
                            <td>Правильных</td>
                            <td>{{ $result->right_answers }}</td>
                        </tr>
                        <tr>
                            <td>Не правильных</td>
                            <td>{{ $result->wrong_answers }}</td>
                        </tr>
                        <tr>
                            <td>Дата сдачи</td>
                            <td>{{ $result->created_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($result->hasAnswers())
    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Отвеченные вопросы</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Вопрос</th>
                            <th>Ответил</th>
                            <th>Правильный ответ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($result->answers as $answer)
                        <tr class="{{ $answer->answer_given == $answer->question->answer ? 'text-success' : 'text-danger' }}">
                            <td>{{ $answer->question->id ?? '' }}</td>
                            <td>{{ $answer->question->question ?? '' }}</td>
                            <td>{{ $answer->answer_given }}</td>
                            <td>{{ $answer->question->answer ?? ''}}</td>
                        </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <a href="{{ route('result.edit', $result->id) }}">...</a>
@endsection