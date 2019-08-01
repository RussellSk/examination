@extends('layouts.admin')


@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Импортирование тестов</h1>
    </div>

    <a href="{{ route('tests.index') }}" class="btn btn-success mb-3">Список тестов</a>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Импортирование данных</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('tests.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="language" class="col-sm-2 col-form-label">Язык тестов</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="language" id="language">
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file" class="col-sm-2 col-form-label">Файл XLS</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control-plaintext" name="xlsfile" id="file">
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body bg-light p-2">
                                <input type="submit" class="btn btn-success" name="uploadXLS" value="Импорт">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection