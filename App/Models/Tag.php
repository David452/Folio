<?php

namespace App\Models;

use Framework\Core\Model;

class Tag extends Model
{
    public int $id;
    public int $category_id;
    public string $name;
}