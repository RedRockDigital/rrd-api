<?php

namespace App\Models;

use App\Models\Pivot\GroupScope;
use App\Traits\HasUuid;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Group
 *
 * @property string $id
 * @property string $name
 * @property string $ref
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Scope[] $scopes
 *
 * @method static GroupFactory factory(...$parameters)
 * @method static Builder|Group newModelQuery()
 * @method static Builder|Group newQuery()
 * @method static Builder|Group query()
 * @method static Builder|Group s()
 * @method static Builder|Group whereCreatedAt($value)
 * @method static Builder|Group whereId($value)
 * @method static Builder|Group whereName($value)
 * @method static Builder|Group whereRef($value)
 * @method static Builder|Group whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Group extends Model
{
    use HasFactory;
    use HasUuid;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'ref',
    ];

    /**
     * @return BelongsToMany
     */
    public function scopes(): BelongsToMany
    {
        return $this->belongsToMany(Scope::class)
            ->using(GroupScope::class);
    }

    /**
     * @param  string  $name
     * @return Group
     */
    public static function getGroup(string $name): Group
    {
        return self::whereRef($name)->first();
    }

    /**
     * @return Group
     */
    public static function getDefault(): Group
    {
        return self::getGroup(config('base.default_group'));
    }
}
