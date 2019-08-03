@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Результаты тестирования</h1>
    </div>

    <a href="{{ route('result.export') }}" class="btn btn-success mb-3">Выгрузить в Excel</a>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Таблица результатов</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                            <tr>
                                <th>id</th>
                                <th>Студент</th>
                                <th>Всего вопросов</th>
                                <th>Ответил на</th>
                                <th>Правильных</th>
                                <th>Не правильных</th>
                                <th>Дата/Время добавления</th>
                                <th>Опции</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($results as $result)
                                <tr>
                                    <td>{{ $result->id }}</td>
                                    <td>{{ $result->student->name ?? '' }}</td>
                                    <td>{{ $result->total_answers }}</td>
                                    <td>{{ $result->total_given_answers }}</td>
                                    <td>{{ $result->right_answers }}</td>
                                    <td>{{ $result->wrong_answers }}</td>
                                    <td>{{ $result->created_at->format('F d, Y h:ia') }}</td>
                                    <td>
                                        <a href="{{ route('result.show', $result->id) }}" class="btn btn-info btn-sm float-left mr-1">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="mt-4 mb-5">
                        {{ $results->appends($_GET)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection