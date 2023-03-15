<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'repo_link', 'description', 'is_published', 'type_id'];

    // link to type table
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // link to pivot table
    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
