<?php
/**
 * Created by PhpStorm.
 * User: RSkaldin
 * Date: 6/18/2019
 * Time: 5:32 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    public function getUrl() {
        return $this->path.'/'.$this->name.'.'.$this->ext;
    }

    public function getAbsolutePathToUploadsFolder() {
        return public_path().'/'.$this->path;
    }

    public function humanSize() {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $this->size > 1024; $i++) {
            $this->size /= 1024;
        }

        return round($this->size, 2) . ' ' . $units[$i];
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'author_id');
    }
}