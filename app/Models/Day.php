<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Day extends Model
{
    protected $fillable = ['name'];

    // Relasi many-to-many dengan Student
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_days')
                    ->withPivot('is_mandatory')
                    ->withTimestamps();
    }

  // Relasi one-to-many dengan Attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
