@extends('layouts.exam')
@section('content')
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <a class="navbar-brand mr-auto mr-lg-0" href="#">TDIU Exam</a>
    </nav>

    <main role="main" class="container pb-5">
        <div class="my-3 p-3 bg-white rounded shadow-sm text-center">
            <h3 class="text-danger">HURMATLI ABITURIYENT!!!</h3>

            SIZGA <strong>50 ta</strong> TEST SINOVLARINI TOPSHIRISH UCHUN <strong>60</strong> MINUT VAQT BERILADI. HAR BIR TEST TOPSHIRIG’I <strong>SAVOL VA 4 ta JAVOB</strong> VARIANTIDAN IBORAT, BARCHA SAVOLLARNI BELGILASH LOZIM! KERAKLI JAVOB VARIANTINI TANLAB UNI BOSHIDAGI DOIRAGA SICHQONCHA TUGMASI BILAN BOSING VA <strong class="text-success">NEXT</strong> TUGMASI ORQALI KEYINGI SAVOLGA O’TING, SO’NGGI SAVOLGA VARIANT TANLANGANIDAN SO’NG <strong class="text-danger">FINISH</strong> TUGMASINI BOSIB TESTNI TUGATING. TEST YAKUNLANGANIDAN SO’NG <strong class="text-danger">SIZNING NATIJANGIZ CHIQQAN OYNANI YOPIB YUBORMANG</strong> VA AUDITORIYA NAZORATCHISI BILAN BIRGALIKDA NATIJANGIZNI RO’YXATDAN O’TKAZIB TASDIQLASHNI UNUTMANG.
            <h4 class="text-primary font-italic">OMAD SIZGA YOR BO’LSIN!</h4>
            TESTNI BOSHLASH UCHUN <strong class="text-success">START</strong> TUGMASINI BOSING!

            <br /><hr /><br />

            <h3 class="text-danger">УВАЖАЕМЫЙ АБИТУРИЕНТ!!!</h3>
            ВАМ ПРЕДОСТАВЛЯЕТСЯ <strong>60</strong> МИНУТ ДЛЯ РЕШЕНИЯ <strong>50</strong> ТЕСТОВЫХ ЗАДАНИЙ. КАЖДЫЙ ТЕСТ СОСТОИТ ИЗ <strong>ВОПРОСА И 4 ВАРИАНТОВ ОТВЕТА</strong>. НА ВСЕ ВОПРОСЫ ДОЛЖНЫ БЫТЬ ВЫБРАНЫ ОТВЕТЫ. ДЛЯ ВЫБОРА ПРАВИЛЬНОГО ОТВЕТА НАЖМИТЕ МЫШКОЙ НА КРУГ ПЕРЕД ТЕМ ВАРИАНТОМ, КОТОРЫЙ ВЫ ВЫБРАЛИ И НАЖМИТЕ НА КНОПКУ <strong class="text-success">NEXT</strong>, НА ПОСЛЕДНЕМ ВОПРОСЕ ПОСЛЕ ВЫБОРА ВАРИАНТА ОТВЕТА НАЖМИТЕ НА КНОПКУ <strong class="text-danger">FINISH</strong> И ЗАКОНЧИТЕ ТЕСТ. ПОСЛЕ ОКОНЧАНИЕ ТЕСТИРОВАНИЯ <strong class="text-danger">НЕ ЗАКРЫВАЙТЕ ОКНО С РЕЗУЛЬТАТОМ </strong>И ПОЗОВИТЕ НАБЛЮДАТЕЛЯ АУДИТОРИИ ДЛЯ ФИКСАЦИИ ВАШЕГО БАЛЛА В ВЕДОМОСТЬ.
            <h4 class="text-primary font-italic">ЖЕЛАЕМ ВАМ УДАЧИ!</h4>
            ЧТО БЫ НАЧАТЬ ТЕСТ НАЖМИТЕ НА КНОПКУ <strong class="text-success">START</strong>.
        </div>
        <div class="text-center">
            <a href="{{ route('exam.tests') }}" class="btn btn-success btn-lg shadow font-weight-bold" style="width: 150px">START</a>
        </div>
    </main>
@endsection