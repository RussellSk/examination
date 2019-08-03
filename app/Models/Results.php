<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    protected $table = 'results';

    public function student() {
        return $this->hasOne('App\Models\Student', 'id', 'student_id');
    }

    public function hasAnswers() {
        return ResultAnswer::where('result_id', $this->id)->count();
    }

    public function answers() {
        return $this->hasMany('App\Models\ResultAnswer', 'result_id', 'id');
    }
}
