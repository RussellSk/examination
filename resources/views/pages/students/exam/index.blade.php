@extends('layouts.exam')
@section('content')

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <a class="navbar-brand mr-auto mr-lg-0" href="#">
            @if (session()->has('student'))
                @php($student = session()->get('student'))
                Abiturient: <span class="text-warning"> {{ $student['name'] }}</span>
            @endif
        </a>
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
                <h4 class="card-title text-center">Question № @{{ currentQuestionIndex+1 }}</h4>
                <p class="card-text" style="font-size: 25px">
                    @{{ currentQuestion.question }}
                </p>
            </div>
        </div>

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">Answer options</h6>
            <div class="media text-muted pt-3" v-for="(answer, index) in currentQuestion.answers" v-bind:class="">
                <div class="form-check" style="font-size: 23px;">
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
                    <button class="btn btn-warning btn-lg" v-on:click="prevQuestion" v-bind:disabled="currentQuestionIndex === 0">Back</button>
                    <button class="btn btn-danger btn-lg float-right ml-4" v-on:click="finishExam()">Finish</button>
                    <button class="btn btn-success btn-lg float-right" v-on:click="nextQuestion" v-bind:disabled="currentQuestionIndex === this.questionsData.length-1">Next</button>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('custom-script')
    <script>

        let app = new Vue({
            el: '#app',

            data: {
                currentQuestionIndex: 0,
                questionActive: true,
                givenAnswers: [],
                answerSelected: "",
                endDate: Date.parse('{{ $endTime ?? ''}}'),
                currentTime: Date.parse('{{ $currentTime ?? ''}}'),
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                hours: null,
                minutes: null,
                seconds: null,
                isEnded: null,
                answers2Char: [
                    'A', 'B', 'C', 'D'
                ],
                currentQuestion: {
                    question: "",
                    answers: [],
                },

                questionsData: [],
            },

            methods: {

                showQuestion: function(index) {
                    this.currentQuestionIndex = index;
                    this.currentQuestion = this.questionsData[index];
                    if (this.questionsData[index].userAnswer === "") {
                        this.answerSelected = false;
                    } else {
                        this.answerSelected = this.questionsData[index].userAnswer;
                    }
                },

                nextQuestion: function () {
                    if (this.currentQuestionIndex + 1 <= this.questionsData.length-1) {
                        this.currentQuestionIndex++;
                        this.showQuestion(this.currentQuestionIndex);
                    }
                },

                prevQuestion: function () {
                    if (this.currentQuestionIndex - 1 >= 0) {
                        this.currentQuestionIndex--;
                        this.showQuestion(this.currentQuestionIndex);
                    }
                },

                navStyleCompute: function (index) {
                    return {
                        'btn-outline-primary': (index !== this.currentQuestionIndex) && this.questionsData[index].userAnswer === "",
                        'btn-primary': (index === this.currentQuestionIndex),
                        'btn-success': (index !== this.currentQuestionIndex) && this.questionsData[index].userAnswer !== "",
                    }
                },

                selectAnswer: function(answer) {
                    this.questionsData[this.currentQuestionIndex].userAnswer = answer;
                },

                updateRemaining: function(distance) {
                    this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((distance % (1000 * 60)) / 1000)
                },

                tick: function() {
                    const currentTime = new Date();
                    const distance = Math.max(this.endDate - currentTime, 0);
                    this.updateRemaining(distance);

                    if (distance === 0) {
                        clearInterval(this.timer);
                        this.isEnded = true;
                        console.log("TIMER ENDED");
                        this.finishExam();
                    }
                },

                finishExam: function () {
                    let self = this;
                    axios
                        .post('/exam/json/finish', this.questionsData, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': self.csrf,
                            }
                        })
                        .then(function (response) {
                            console.log('FINISH');
                            window.location.replace("/exam/results");
                        });
                },

            },

            mounted: function() {
                let self = this;
                axios
                    .get('/exam/json/questions')
                    .then(function (response) {
                        self.questionsData = _.shuffle(response.data);
                        self.currentQuestion = self.questionsData[0];
                        self.tick();
                        self.timer = setInterval(self.tick.bind(self), 1000)
                    });
            },

            filters: {
                twoDigits: function (value) {
                    if (value === null) return value;

                    if (value < 0) {
                        return '00';
                    }
                    if (value.toString().length <= 1) {
                        return `0${value}`;
                    }
                    return value;
                }
            },

        });
    </script>
@endsection