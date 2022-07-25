<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class category extends Model
{
    use HasFactory,   SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_name',

    ];



    public function user()
    {
        return $this->hasOne(user::class, 'id','user_id');
    }
}
