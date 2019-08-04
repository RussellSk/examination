<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    public function language() {
        return $this->hasOne('App\Models\Language', 'id', 'language_id');
    }

    public function hasResult() {
        return Results::where('student_id', $this->id)->count();
    }

    public function result() {
        return $this->hasOne('App\Models\Results', 'student_id', 'id');
    }

    public function hasCorrect() {
        return Correct::where('student_code', $this->code)->count();
    }

    public function correct() {
        return $this->hasOne('App\Models\Correct', 'student_code', 'code');
    }
}
