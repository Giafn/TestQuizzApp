<?php

namespace App\Models;

use App\AutoGenerateUUidID;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use AutoGenerateUUidID;

    protected $table = 'quizzs';
    
    protected $fillable = [
        'category_id',
        'class_id',
        'user_id',
        'code',
        'visibility',
        'name',
        'desc',
        'min_pts',
        'duration',
        'start_time',
        'end_time',
    ];
    
}
