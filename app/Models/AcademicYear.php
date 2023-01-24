<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function academicTerms()
    {
        return $this->hasMany(AcademicTerm::class , 'academic_year_id', 'id');

    }
}
