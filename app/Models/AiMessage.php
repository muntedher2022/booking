<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'type',
        'content',
    ];

    /**
     * العلاقة مع المحادثة
     */
    public function conversation()
    {
        return $this->belongsTo(AiConversation::class, 'conversation_id');
    }
}
