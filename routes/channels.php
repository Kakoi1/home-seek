<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel('message.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel('fetch.{chat_id}.{type}', function ($user, $chat_id, $type) {
    // Generalize the check based on the chat type
    if ($type === 'dorm') {
        return $user->isPartOfDormChatRoom($chat_id);
    } elseif ($type === 'room') {
        return $user->isPartOfRoomChatRoom($chat_id);
    }

    return false;
});