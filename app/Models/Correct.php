<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correct extends Model
{
    protected $table = 'correct';

    public function student() {
        return $this->hasOne('App\Models\Student', 'code', 'student_code');
    }
}
