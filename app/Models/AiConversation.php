<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiConversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع الرسائل
     */
    public function messages()
    {
        return $this->hasMany(AiMessage::class, 'conversation_id');
    }
}
