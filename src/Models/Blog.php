<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Tags\HasTags;

class Blog extends Model
{
    use HasFactory;
    use HasUuid;
    use HasTags;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'author',
        'body',
        'snippet',
        'published_at',
        'estimate_read_time',
        'featured_image',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'featured_image_url',
        'tags',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'categories'   => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * @return string|null
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? Storage::url($this->featured_image) : null;
    }

    /**
     * @return Collection
     */
    public function getTagsAttribute(): Collection
    {
        return $this->tags()->get();
    }
}
