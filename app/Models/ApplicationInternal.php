<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class ApplicationInternal extends Model
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'application_internals'; // Table name in the database
    protected $primaryKey = 'ApplicationID';

    public $incrementing = false; // Disable auto-incrementing for primary key
    protected $keyType = 'string'; // Set the primary key type to string

    protected $fillable = [
        'StudentID',
        'ScholarshipID',
        'ApplicationDate',
        'Status',
        'MonthlyIncome',
        'MonthlyExpenses',
        'NumberOfSiblings',
        'NumberOfSisters',
        'NumberOfBrothers',
    ];

    protected $casts = [
        'ApplicationDate' => 'date',
        'MonthlyIncome' => 'float',
        'MonthlyExpenses' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate ApplicationID with prefix IN
        static::creating(function ($model) {
            if (empty($model->ApplicationID)) {
                $model->ApplicationID = 'IN-' . strtoupper(Str::random(10));
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'StudentID', 'StudentID');
    }


    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'ScholarshipID', 'ScholarshipID');
    }

    public function applicationFiles()
    {
        return $this->hasMany(ApplicationFile::class, 'ApplicationID', 'ApplicationID');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'ApplicationID', 'ApplicationID');
    }

    public function siblings()
    {
        return $this->hasMany(Sibling::class, 'ApplicationID', 'ApplicationID');
    }

    public function scholarshipHistories()
    {
        return $this->hasMany(ScholarshipHistory::class, 'ApplicationID', 'ApplicationID');
    }

    public function guardians()
    {
        return $this->hasMany(Guardian::class, 'ApplicationID', 'ApplicationID');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'ApplicationID', 'ApplicationID');
    }

    public function educationHistories()
    {
        return $this->hasMany(EducationHistory::class, 'ApplicationID', 'ApplicationID');
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class, 'ApplicationID', 'ApplicationID');
    }
}
