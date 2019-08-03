<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultAnswer extends Model
{
    protected $table = 'result_answers';

    public function question() {
        return $this->hasOne('App\Models\Test', 'id', 'question_id');
    }
}
