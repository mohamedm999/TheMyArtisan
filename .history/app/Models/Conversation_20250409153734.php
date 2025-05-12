<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'artisan_id',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the client user of the conversation
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the artisan user of the conversation
     */
    public function artisan()
    {
        return $this->belongsTo(User::class, 'artisan_id');
    }

    /**
     * Get the messages for this conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message from the conversation
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * Get unread messages count for a specific user
     */
    public function unreadMessages($userId)
    {
        return $this->messages()
            ->where('is_read', false)
            ->where('sender_id', '!=', $userId)
            ->count();
    }
}
