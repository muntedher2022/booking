<?php

namespace App\Models\Incomingbooks;

use App\Models\Sections\Sections;
use App\Models\Departments\Departments;
use Illuminate\Database\Eloquent\Model;
use App\Models\Outgoingbooks\OutgoingBooks;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incomingbooks extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "incomingbooks";

    public function Getdepartment()
    {
        $senderIds = json_decode($this->sender_id, true);
        if (is_array($senderIds) && !empty($senderIds)) {
            return Departments::whereIn('id', $senderIds)->get();
        }
        return collect();
    }

    public function Getsection()
    {
        return $this->belongsTo(Sections::class, 'sender_id');
    }
}
