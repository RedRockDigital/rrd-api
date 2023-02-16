<?php

namespace RedRockDigital\Api\Models;

use RedRockDigital\Api\Traits\HasUuid;
use ArrayAccess;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Tags\HasTags;

/**
 * RedRockDigital\Api\Models\Webhook
 *
 * @property string           $id
 * @property string           $originator
 * @property string           $hook
 * @property mixed            $payload
 * @property mixed|null       $response
 * @property string           $status
 * @property string           $idem_key
 * @property Carbon|null      $created_at
 * @property Carbon|null      $updated_at
 * @property Collection|Tag[] $tags
 * @property-read int|null    $tags_count
 * @method static Builder|Webhook newModelQuery()
 * @method static Builder|Webhook newQuery()
 * @method static Builder|Webhook query()
 * @method static Builder|Webhook whereCreatedAt($value)
 * @method static Builder|Webhook whereHook($value)
 * @method static Builder|Webhook whereId($value)
 * @method static Builder|Webhook whereOriginator($value)
 * @method static Builder|Webhook wherePayload($value)
 * @method static Builder|Webhook whereResponse($value)
 * @method static Builder|Webhook whereStatus($value)
 * @method static Builder|Webhook whereIdemKey($value)
 * @method static Builder|Webhook whereUpdatedAt($value)
 * @method static Builder|Webhook withAllTags(ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static Builder|Webhook withAllTagsOfAnyType($tags)
 * @method static Builder|Webhook withAnyTags(ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static Builder|Webhook withAnyTagsOfAnyType($tags)
 * @method static Builder|Webhook withoutTags(ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 *
 * @mixin Eloquent
 */
final class Webhook extends Model
{
    use HasFactory;
    use HasTags;
    use HasUuid;

    /**
     * @var string[]
     */
    protected $fillable = [
        'originator',
        'hook',
        'payload',
        'response',
        'status',
        'idem_key',
    ];

    protected $casts = [
        'payload'  => 'json',
        'response' => 'json',
    ];

    /**
     * Check if a webhook with the given idem key exists
     * 
     * @param string $idemKey
     *
     * @return bool
     */
    public static function checkIdemKey(string $idemKey): bool
    {
        return self::whereIdemKey($idemKey)
            ->whereIn('status', ['processing', 'completed'])
            ->exists();
    }

    /**
     * Marks a webhook as failed due to an exception
     * 
     * @param string $idemKey
     *
     * @return void
     */
    public static function markAsFailed(string $idemKey): void
    {
        self::whereIdemKey($idemKey)->update(['status' => 'failed']);
    }

    /**
     * Set the response for a webhook
     *
     * @param string $customerId
     * @param string $teamId
     * @param string $message
     *
     * @return void
     */
    public function setResponse(string $customerId, string $teamId, string $message): void
    {
        $this->update([
            'status'   => 'completed',
            'response' => [
                'message' => "Customer ID ($customerId) on Team ($teamId) $message",
            ]
        ]);
    }
}
