<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('private-channel.user.{id}', function ($user, $id){
    \Log::info('User accessing channel', ['user_id' => $user->id, 'channel_id' => $id]);
    return (int) $user->id === (int) $id;
});