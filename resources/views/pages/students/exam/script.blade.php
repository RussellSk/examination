<script>

    let app = new Vue({
        el: '#app',

        data: {
            props: ['finishTime'],
            currentQuestionIndex: 0,
            questionActive: true,
            givenAnswers: [],
            answerSelected: "",
            endDate: Date.parse({{ $endTime ?? ''}}),
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
                        //window.location.href = "/exam/result";
                    });
            },

        },

        mounted: function() {
            let self = this;
            axios
                .get('/exam/json/questions')
                .then(function (response) {
                    console.log(response);
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