<?php

namespace RedRockDigital\Api\Models;

use RedRockDigital\Api\Traits\HasUuid;
use Spatie\Tags\Tag as TagModel;

class Tag extends TagModel
{
    use HasUuid;
}
