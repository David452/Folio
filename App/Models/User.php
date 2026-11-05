<?php

namespace App\Models;

use DateTime;
use Framework\Core\IIdentity;
use Framework\Core\Model;

class User extends Model implements IIdentity {
    public int $id;
    public string $username;
    public string $email;
    public string $password_hash;
    public string $role;
    public string $display_name;
    public string $bio;
    public string $avatar_path;
    public bool $is_banned;
    public int $theme_id;
    public DateTime $created_at;

    public function getName(): string
    {
        return $this->username;
    }
}