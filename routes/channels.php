<?php


Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('NotificationChannel', function($doctor){
    return $doctor;
});
Broadcast::channel('CallingChannel', function($agent){
    return $agent;
});
