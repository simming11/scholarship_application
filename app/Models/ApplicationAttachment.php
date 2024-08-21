<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationAttachment extends Model
{
    use HasFactory;

    protected $primaryKey = 'AttachmentID';

        // กำหนดให้ ApplicationID เป็น string
        protected $keyType = 'string';
        public $incrementing = false; // ปิดการเพิ่มค่าอัตโนมัติ

    protected $fillable = [
        'ApplicationID',
        'FilePath',
    ];

    public function application()
    {
        return $this->belongsTo(ApplicationInternal::class, 'ApplicationID');
    }
}
