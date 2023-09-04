<?php


use App\Models\Role;
use App\Models\Tag;
use App\Models\User;

return [
    [
        'title' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'fas fa-tachometer-alt',
    ],

    [
        'title' => 'Tags',
        'route' => 'tags.index',
        'icon' => 'fas fa-tags',
        'ability' => ['viewAny' , Tag::class],
    ],

    [
        'title' => 'Roles',
        'route' => 'roles.index',
        'icon' => 'fas fa-user-shield',
        'ability' => ['viewAny' , Role::class],
    ],

    [
        'title' => 'Admins',
        'route' => 'admins.index',
        'icon' => 'fas fa-user-shield',
        'ability' => ['viewAny' , User::class],
    ],

];
