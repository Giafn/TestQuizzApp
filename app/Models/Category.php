<?php

namespace App\Models;

use App\AutoGenerateUUidID;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use AutoGenerateUUidID;

    protected $table = 'categories';
    
    protected $fillable = [
        'name',
        'icon',
        'desc',
    ];
    
    public function quizzes()
    {
        return $this->hasMany(Quizz::class, 'category_id');
    }
}
