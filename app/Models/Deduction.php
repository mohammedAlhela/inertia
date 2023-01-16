<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'notes',
        'details',
        'total',
        'date',
        'salary_payment',
        'deduction',
        'bouns',

    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updatd_at' => 'datetime:Y-m-d',
        'date' => 'datetime:Y-m-d',
    ];

    protected $appends = ['manage'];

    public function getManageAttribute()
    {
        return false;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
