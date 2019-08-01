@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Управление языками</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Добавление языка</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('language.create') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">Язык</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="file">
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body bg-light p-2">
                                <input type="submit" class="btn btn-success" name="uploadXLS" value="Добавить">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Таблица добавленных языков</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                            <tr>
                                <th>id</th>
                                <th>Название</th>
                                <th>Дата/Время добавления</th>
                                <th>Опции</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($languages as $language)
                                <tr>
                                    <td>{{ $language->id }}</td>
                                    <td>{{ $language->name }}</td>
                                    <td>{{ $language->created_at->format('F d, Y h:ia') }}</td>
                                    <td>
                                        <form action="{{ route('language.delete', $language->id) }}" method="post">
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

                </div>
            </div>
        </div>
    </div>


@endsection