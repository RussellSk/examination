@extends('layouts.exam')
@section('content')
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <a class="navbar-brand mr-auto mr-lg-0" href="#">Exam 1.0</a>
        <div class="ml-auto font-weight-bold" style="color: #8bc34a">
            <h3>@{{ hours | twoDigits }} : @{{ minutes | twoDigits }} : @{{ seconds | twoDigits}}</h3>
        </div>
    </nav>

    <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav">
            <div class="container">
                <div class="align-items-center align-middle p-3">
                    <h3><a href="#" class="btn mr-1 mt-1"
                           v-for="(item, index) in questionsData"
                           v-bind:class="navStyleCompute(index)"
                           v-on:click="showQuestion(index)"> @{{ index+1 }}</a></h3>
                </div>
            </div>
        </nav>
    </div>

    <main role="main" class="container pb-5">

        <div class="card mt-5">
            <div class="card-body">
                <h4 class="card-title">Вопрос № @{{ currentQuestionIndex+1 }}</h4>
                <p class="card-text">@{{ currentQuestion.question }}</p>
            </div>
        </div>

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">Варианты ответов</h6>
            <div class="media text-muted pt-3" v-for="(answer, index) in currentQuestion.answers" v-bind:class="">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answerOption"
                           :id="'radio_' + answers2Char[index]"
                           :value="answers2Char[index]" v-on:input="selectAnswer(answers2Char[index])"
                            v-model="answerSelected">
                    <label class="form-check-label" :for="'radio_' + answers2Char[index]" v-bind:class="{'text-success font-weight-bold': answerSelected === answers2Char[index]}">
                        <strong>@{{ answers2Char[index] }}) </strong>
                            @{{ answer }}
                    </label>
                </div>

            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-body p-3">
                <div class="card-text">
                    <button class="btn btn-warning btn-lg" v-on:click="prevQuestion" v-bind:disabled="currentQuestionIndex === 0">Назад</button>
                    <button class="btn btn-danger btn-lg float-right ml-4" v-on:click="finishExam()">Завершить</button>
                    <button class="btn btn-success btn-lg float-right" v-on:click="nextQuestion" v-bind:disabled="currentQuestionIndex === this.questionsData.length-1">Далее</button>
                </div>
            </div>
        </div>

    </main>
@endsection