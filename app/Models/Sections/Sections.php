<?php
namespace App\Models\Sections;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sections extends Model
{
     use HasFactory;
    protected $guarded = [];
    protected $table = "sections";
    protected $fillable = ['user_id', 'section_name'];

    /* public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    } */
    public function user()
    {
        return $this->belongsToMany(User::class, 'section_user', 'section_id', 'user_id');
    }
}
