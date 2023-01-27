<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Course::class , 'department_id', 'id');

    }

    public function subjects()
    {
        return $this->hasMany(Subject::class , 'department_id', 'id');

    }



}
