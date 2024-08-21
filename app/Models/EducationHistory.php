<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationHistory extends Model
{
    use HasFactory;

    protected $table = 'education_histories'; // กำหนดชื่อตาราง
    protected $primaryKey = 'HistoriesID'; // Primary key ของตาราง

    public $incrementing = false; // ปิดการเพิ่มค่าอัตโนมัติ
    protected $keyType = 'string'; // กำหนดประเภทของ primary key เป็น string

    protected $fillable = [
        'ApplicationID',
        'EducationLevel',
        'AcademicYear',
        'GPA',
        'AdvisorName',
        'CourseName',
    ];

    /**
     * กำหนดความสัมพันธ์กับตาราง applications
     */
    public function application()
    {
        return $this->belongsTo(ApplicationInternal::class, 'ApplicationID', 'ApplicationID');
    }
}
