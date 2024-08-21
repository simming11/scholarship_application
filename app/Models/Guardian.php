<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $table = 'guardians'; // กำหนดชื่อตาราง
    protected $primaryKey = 'GuardiansID'; // Primary key ของตาราง
    
    public $incrementing = false; // ปิดการเพิ่มค่าอัตโนมัติ
    protected $keyType = 'string'; // กำหนดประเภทของ primary key เป็น string
    
    protected $fillable = [
        'ApplicationID',
        'FirstName',
        'LastName',
        'Type',
        'Occupation',
        'Income',
        'Age',
        'Status',
        'Workplace',
    ];

    /**
     * กำหนดความสัมพันธ์กับตาราง applications
     */
    public function application()
    {
        return $this->belongsTo(ApplicationInternal::class, 'ApplicationID', 'ApplicationID');
    }
}
