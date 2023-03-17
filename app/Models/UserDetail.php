<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'phone', 'address', 'date_of_birth'];

    // link to user table (one-to-one)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
