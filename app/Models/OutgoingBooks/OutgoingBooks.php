<?php

namespace App\Models\Outgoingbooks;

use App\Models\Sections\Sections;
use App\Models\Departments\Departments;
use Illuminate\Database\Eloquent\Model;
use App\Models\Incomingbooks\Incomingbooks;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outgoingbooks extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "outgoingbooks";

    public function Getdepartment()
    {
        $recipientIds = json_decode($this->recipient_id, true);
        if (is_array($recipientIds) && !empty($recipientIds)) {
            return Departments::whereIn('id', $recipientIds)->get();
        }
        return collect();
    }

    public function Getsection()
    {
        return $this->belongsTo(Sections::class, 'recipient_id');
    }

    public function Getincomingbook()
    {
        return $this->belongsTo(IncomingBooks::class, 'related_book_id');
    }
}
