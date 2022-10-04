<?php

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\User as Repository;
use App\Models\Subject;
use App\Models\Project;
use Carbon\Carbon;

class AuthManager
{
    /**
     * Create a token
     */
    public static function createToken( $repository )
    {
        $tokenResult = $repository->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addDay();
        $token->save();

        return $tokenResult->accessToken;
    }

    /**
     * Destroy all token of given repository
     */
    public static function revokeToken( $tokens )
    {
        foreach ($tokens as $token) {

            $token->revoke();
        }
    }

}
