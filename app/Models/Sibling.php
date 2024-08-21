<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{
    use HasFactory;

    protected $table = 'siblings'; // กำหนดชื่อตาราง
    protected $primaryKey = 'SiblingsID'; // Primary key ของตาราง

    public $incrementing = false; // ปิดการเพิ่มค่าอัตโนมัติ
    protected $keyType = 'string'; // กำหนดประเภทของ primary key เป็น string

    protected $fillable = [
        'ApplicationID',
        'PrefixName',
        'Fname',
        'Lname',
        'Occupation',
        'EducationLevel',
        'Income',
        'Status',
    ];

    /**
     * กำหนดความสัมพันธ์กับตาราง applications
     */
    public function application()
    {
        return $this->belongsTo(ApplicationInternal::class, 'ApplicationID', 'ApplicationID');
    }
}
