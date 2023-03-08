<?php

namespace RedRockDigital\Api\Models;

use RedRockDigital\Api\Traits\HasUuid;
use ArrayAccess;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\{
    Builder,
    Model,
    Collection
};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Spatie\Tags\HasTags;

/**
 * RedRockDigital\Api\Models\Webhook
 *
 * @property string      $id
 * @property string      $provider
 * @property string      $event
 * @property mixed       $payload
 * @property mixed|null  $output
 * @property string      $status
 * @property string      $identifier
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Webhook newModelQuery()
 * @method static Builder|Webhook newQuery()
 * @method static Builder|Webhook query()
 * @method static Builder|Webhook whereCreatedAt($value)
 * @method static Builder|Webhook whereEvent($value)
 * @method static Builder|Webhook whereId($value)
 * @method static Builder|Webhook whereProvider($value)
 * @method static Builder|Webhook wherePayload($value)
 * @method static Builder|Webhook whereOutput($value)
 * @method static Builder|Webhook whereStatus($value)
 * @method static Builder|Webhook whereIdentifier($value)
 * @method static Builder|Webhook whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
final class Webhook extends Model
{
    use HasFactory;
    use HasTags;
    use HasUuid;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'provider',
        'event',
        'payload',
        'output',
        'status',
        'identifier',
    ];

    /**
     * @var array $casts
     */
    protected $casts = [
        'payload' => 'json',
        'output'  => 'json',
    ];

    /**
     * Check if a webhook with the given idem key exists
     *
     * @param string $identifier
     *
     * @return bool
     */
    public static function verify(string $identifier, string $event): bool
    {
        return self::whereIdentifier($identifier)
            ->whereEvent($event)
            ->whereIn('status', ['processing', 'completed'])
            ->exists();
    }

    /**
     * Marks a webhook as failed due to an exception
     *
     * @param string $key
     * @param string $error
     *
     * @return void
     */
    public function markAsFailed(string $error = ''): void
    {
        $this->update([
            'status' => 'failed',
            'output' => [
                'message' => 'An exception was thrown while processing the webhook',
                'error'   => $error
            ]
        ]);
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
    public function setTeamResponse(string $teamId, string $message): void
    {
        $this->update([
            'status' => 'completed',
            'output'  => [
                'message' => "Team ($teamId) $message",
            ]
        ]);
    }
}
