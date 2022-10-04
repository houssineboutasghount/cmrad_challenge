<?php

namespace App\Classes;

use App\Models\User;

class RepositoryManager
{
    /**
     * Create repository
     */
    public static function createRepository( $name, $email, $password )
    {
        User::create([
            'name' => $name,
            'password' => bcrypt($password),
            'email' => $email,
        ]);

        return "Repository created successfully!";
    }
}
