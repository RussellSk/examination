
let app = new Vue({
    el: '#app',

    data: {
        currentQuestionIndex: 0,
        questionActive: true,
        givenAnswers: [],
        answerSelected: "",
        endDate: Date.parse('2019-08-01 00:02:00'),
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

        questionsData: [
            {
                question: "Question 1",
                userAnswer: '',
                answers: [
                    'Answer A is here 1',
                    'Answer B is here 1',
                    'Answer C is here 1',
                    'Answer D is here 1',
                ]
            },
            {
                question: "Question 2",
                userAnswer: '',
                answers: [
                    'Answer A is here 2 Components are reusable Vue instances with a name: in this case, <button-counter>. We can use this component as a custom element inside a root Vue instance created with new Vue:',
                    'Answer B is here 2',
                    'Answer C is here 2',
                    'Answer D is here 1',
                ]
            },
            {
                question: "Question 3",
                userAnswer: '',
                answers: [
                    'Answer A is here 3',
                    'Answer B is here 3',
                    'Answer C is here 3',
                ]
            },
            {
                question: "Question 4",
                userAnswer: '',
                answers: [
                    'Answer A is here 3',
                    'Answer B is here 3',
                    'Answer C is here 3',
                ]
            },
            {
                question: "Question 5",
                userAnswer: '',
                answers: [
                    'Answer A is here 3',
                    'Answer B is here 3',
                    'Answer C is here 3',
                ]
            },
        ],
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
            console.log(this.questionsData)
        },

        updateRemaining (distance) {
            this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
            this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((distance % (1000 * 60)) / 1000)
        },

        tick () {
            const currentTime = new Date();
            const distance = Math.max(this.endDate - currentTime, 0);
            this.updateRemaining(distance);

            if (distance === 0) {
                clearInterval(this.timer);
                this.isEnded = true;
                console.log("TIMER ENDED")
            }
        }

    },

    mounted: function() {
        this.currentQuestion = this.questionsData[0];
        this.tick();
        this.timer = setInterval(this.tick.bind(this), 1000)

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