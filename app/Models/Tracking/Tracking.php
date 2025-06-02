<?php
namespace App\Models\Tracking;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tracking extends Model
{
     use HasFactory;
    protected $guarded = [];
    protected $table = "tracking";

    Public function Getuser()
    {
        return $this->belongsTo(User::class, 'user_id' );
    }

}
