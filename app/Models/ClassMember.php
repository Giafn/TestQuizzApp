<?php

namespace App\Models;

use App\AutoGenerateUUidID;
use Illuminate\Database\Eloquent\Model;

class ClassMember extends Model
{
    use AutoGenerateUUidID;
    
    protected $table = 'class_member';
    protected $fillable = [
        'id',
        'class_id',
        'user_id',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
