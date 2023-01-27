<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class , 'course_id', 'id');

    }

    public function sections()
    {
        return $this->hasMany(Section::class , 'course_id', 'id');

    }

}
