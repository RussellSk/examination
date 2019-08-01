<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';

    public function language() {
        return $this->hasOne('App\Models\Language', 'id', 'language_id');
    }
}
