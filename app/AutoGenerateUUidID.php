<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait AutoGenerateUUidID
{
    protected static function bootAutoGenerateUUidID()
    {
        static::creating(function (Model $model) {
            $model->id = Str::uuid(); // Mengatur UUID saat record dibuat
        });
    }

    public function getIncrementing()
    {
        return false; // Mengatur incrementing menjadi false
    }

    public function getKeyType()
    {
        return 'string'; // Mengatur key type menjadi string
    }
}
