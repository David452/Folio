<?php

namespace App\Auth;

use App\Models\User;
use Framework\Auth\SessionAuthenticator;
use Framework\Core\IIdentity;

class DbAuthenticator extends SessionAuthenticator {
    protected function authenticate(string $username, string $password): ?IIdentity
    {
        $user = User::getAll('`username` = ?', [$username])[0] ?? null;
        if ($user !== null && password_verify($password, $user->password_hash)) {
            return $user;
        }

        return null;
    }
}
