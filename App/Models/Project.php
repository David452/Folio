<?php

namespace App\Models;

use Framework\Core\Model;

class Project extends Model {
    public int $id;
    public int $user_id;
    public string $title;
    public string $short_description;
    public string $cover_image_path;
    public int $is_public;
    public string $created_at;
    public string $updated_at;
}
