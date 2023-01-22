<?php

namespace App\Models;

use App\Traits\HasUuid;
use Spatie\Tags\Tag as TagModel;

class Tag extends TagModel
{
    use HasUuid;
}
