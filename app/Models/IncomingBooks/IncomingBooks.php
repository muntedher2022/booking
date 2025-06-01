<?php

namespace App\Models\IncomingBooks;

use App\Models\Sections\Sections;
use App\Models\Departments\Departments;
use Illuminate\Database\Eloquent\Model;
use App\Models\Outgoingbooks\OutgoingBooks;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomingBooks extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "incomingbooks";

    public function Getdepartment()
    {
        $senderData = json_decode($this->sender_id, true);
        if (!is_array($senderData)) {
            return collect();
        }

        $departmentIds = array_values(array_filter(array_map(function($item) {
            return isset($item['type']) && $item['type'] === 'dep' ? $item['id'] : null;
        }, $senderData)));

        return empty($departmentIds) ? collect() : Departments::whereIn('id', $departmentIds)->get();
    }

    public function Getsection()
    {
        $senderData = json_decode($this->sender_id, true);
        if (!is_array($senderData)) {
            return collect();
        }

        $sectionIds = array_values(array_filter(array_map(function($item) {
            return isset($item['type']) && $item['type'] === 'sec' ? $item['id'] : null;
        }, $senderData)));

        return empty($sectionIds) ? collect() : Sections::whereIn('id', $sectionIds)->get();
    }

    public function relatedBook()
    {
        return $this->belongsTo(Incomingbooks::class, 'related_book_id');
    }
}
