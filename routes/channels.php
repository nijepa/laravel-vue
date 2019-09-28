<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

// Broadcast chat messages
Broadcast::channel('messages.{id}', function ($user, $id) {
    return $user->id === (int) $id;
});

// Broadcast user status (online, offline) for chat
Broadcast::channel('chat', function ($user) {
    if(auth()->check()){
        return $user;
    }
});