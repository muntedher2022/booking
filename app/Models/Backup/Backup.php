<?php

namespace App\Models\Backup;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Backup extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "backups";
    protected $fillable = ['user_id', 'filename', 'type', 'size'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
