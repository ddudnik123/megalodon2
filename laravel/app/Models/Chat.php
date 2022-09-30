<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function chatable()
    {
        return $this->morphTo('chatable');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'chat_users', 'chat_id', 'user_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'chat_id', 'id')->latest('created_at')->first();;
    }
}
