@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Управление студентами</h1>
    </div>

    <a href="{{ route('importUsersShowUpload') }}" class="btn btn-success mb-3">Импортировать XLS</a>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Таблица студентов</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                            <tr>
                                <th>Имя</th>
                                <th>Код</th>
                                <th>Логин</th>
                                <th>Пароль</th>
                                <th>Прошел</th>
                                <th>Дата/Время добавления</th>
                                <th>Опции</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($students as $student)
                                <tr>

                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->code }}</td>
                                    <td>{{ $student->enter_code }}</td>
                                    <td>{{ $student->enter_code }}</td>
                                    <td>
                                        @if($student->attended)
                                            <span class="badge badge-success">Да</span>
                                        @else
                                            <span class="badge badge-primary">Нет</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->created_at->format('F d, Y h:ia') }}</td>
                                    <td>
                                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-info btn-sm float-left mr-1">Edit</a>
                                        <form action="{{ route('student.delete', $student->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="mt-4 mb-5">
                        {{ $students->appends($_GET)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection