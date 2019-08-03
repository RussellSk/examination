@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Детализация результата (Редактирование)</h1>
    </div>

    <form action="{{ route('result.update', $result->id) }}" method="post">
        @csrf
        @method('PUT')

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
                                <td>
                                    <input type="text" class="form-control" name="total_answers" value="{{ $result->total_answers }}" />
                                </td>
                            </tr>
                            <tr>
                                <td>Ответил на вопросы</td>
                                <td>
                                    <input type="text" class="form-control" name="total_given_answers" value="{{ $result->total_given_answers }}" />
                                </td>
                            </tr>
                            <tr>
                                <td>Правильных</td>
                                <td>
                                    <input type="text" class="form-control" name="right_answers" value="{{ $result->right_answers }}" />
                                </td>
                            </tr>
                            <tr>
                                <td>Не правильных</td>
                                <td>
                                    <input type="text" class="form-control" name="wrong_answers" value="{{ $result->wrong_answers }}"/>
                                </td>
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
                                        <td>
                                            <input type="hidden" name="question_id[]" value="{{ $answer->question->id ?? '' }}" />
                                            <input type="hidden" name="answer_id[]" value="{{ $answer->id }}" />
                                            <input type="text" class="form-control" name="answer_option[]" value="{{ $answer->answer_given }}" />
                                        </td>
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

        <input type="submit" class="btn btn-success mb-3" value="Сохранить" />
    </form>

@endsection