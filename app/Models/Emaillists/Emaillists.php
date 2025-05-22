<?php

namespace App\Models\Emaillists;

use App\Models\Sections\Sections;
use App\Models\Departments\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emaillists extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "emaillists";
    protected $fillable = ['user_id', 'type', 'department', 'email', 'notes'];

    public function Getsection()
    {
        return $this->belongsTo(Sections::class, 'department');
    }

    public function Getdepartment()
    {
        return $this->belongsTo(Departments::class, 'department');
    }
}
