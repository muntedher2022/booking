<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'title',
        'source',        // مصدر التقرير (مثل: incomingbooks, tracking, etc)
        'filters',       // فلاتر التقرير بصيغة JSON
        'columns',       // الأعمدة المطلوبة بصيغة JSON
        'created_by',    // منشئ التقرير
        'status'
    ];

    protected $casts = [
        'filters' => 'array',
        'columns' => 'array'
    ];
}
