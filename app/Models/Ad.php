<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'title', 'price', 'description'];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
