<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    <div class="container-fluid">
        @foreach($students as $student)
            <div class="row">
                <div class="col-12">
                    ФИО: <strong>{{ $student->name }}</strong> ID: <strong>{{ $student->code }}</strong> Логин: <strong>{{ $student->enter_code }}</strong>  Пароль: <strong>{{ $student->enter_password }}</strong>
                </div>
            </div>
            <hr/>
        @endforeach
    </div>
</body>
</html>