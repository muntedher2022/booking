<?php
namespace App\Models\Departments;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departments extends Model
{
     use HasFactory;
    protected $guarded = [];
    protected $table = "departments";
    protected $fillable = ['user_id', 'department_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
