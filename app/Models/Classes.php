<?php

namespace App\Models;

use App\AutoGenerateUUidID;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use AutoGenerateUUidID;

    protected $table = 'classes';
    protected $fillable = [
        'id',
        'created_by',
        'code',
        'name',
        'desc',
        'number_of_member',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function members()
    {
        return $this->hasMany(ClassMember::class, 'class_id', 'id');
    }
}
