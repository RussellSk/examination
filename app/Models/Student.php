<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    public function language() {
        return $this->hasOne('App\Models\Language', 'id', 'language_id');
    }
}
