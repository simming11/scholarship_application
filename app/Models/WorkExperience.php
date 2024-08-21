<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experiences'; // กำหนดชื่อตาราง
    protected $primaryKey = 'WorkExperienceID'; // Primary key ของตาราง

    public $incrementing = false; // ปิดการเพิ่มค่าอัตโนมัติ
    protected $keyType = 'string'; // กำหนดประเภทของ primary key เป็น string

    protected $fillable = [
        'ApplicationID',
        'Name',
        'JobType',
        'Duration',
        'Earnings',
    ];

    /**
     * กำหนดความสัมพันธ์กับตาราง applications
     */
    public function application()
    {
        return $this->belongsTo(ApplicationInternal::class, 'ApplicationID', 'ApplicationID');
    }
}
