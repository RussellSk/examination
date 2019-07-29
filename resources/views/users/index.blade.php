@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Управление пользователями</h1>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm mb-3">Добавить пользователя</a>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Таблица Пользователей</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                            <tr>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Дата/Время добавления</th>
                                <th>Опции</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($users as $user)
                                <tr>

                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm float-left mr-1">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
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
                        {{ $users->appends($_GET)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>



@endsection