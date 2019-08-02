@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Управление студентами</h1>
    </div>

    <a href="{{ route('importUsersShowUpload') }}" class="btn btn-success mb-3">Импортировать XLS</a>
    <a href="{{ route('student.generate') }}" class="btn btn-primary mb-3">Сгенерировать логин и пароль</a>
    <a href="#" class="btn btn-outline-primary mb-3 ml-2" onclick="return printPage()">Распечатать доступы</a>
    <div id="printerDiv" style="display:none"></div>

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
                                <th>Логин</th>
                                <th>Пароль</th>
                                <th>Прошел</th>
                                <th>Язык</th>
                                <th>Дата/Время добавления</th>
                                <th style="min-width: 100px;">Опции</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($students as $student)
                                <tr>

                                    <td>
                                        {{ $student->name }}
                                        ({{ $student->code }})
                                    </td>
                                    <td>{{ $student->enter_code }}</td>
                                    <td>{{ $student->enter_password }}</td>
                                    <td>
                                        @if($student->attended)
                                            <span class="badge badge-success">Да</span>
                                        @else
                                            <span class="badge badge-primary">Нет</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->language->name ?? '' }}</td>
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

@section('app-script')
    <script>
        function printPage()
        {
            var div = document.getElementById("printerDiv");
            div.innerHTML = '<iframe src="{{ route('student.print') }}" onload="this.contentWindow.print();"></iframe>';
            return false;
        }
    </script>
@endsection