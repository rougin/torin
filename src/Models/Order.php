<?php

namespace Rougin\Torin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer      $id
 * @property integer|null $client_id
 * @property string       $code
 * @property string       $remarks
 * @property integer      $type
 * @property integer      $status
 *
 * @method integer                         count()
 * @method boolean                         delete()
 * @method \Rougin\Torin\Models\Order      create(array<string, mixed> $data)
 * @method \Rougin\Torin\Models\Order      findOrFail(mixed $id)
 * @method \Rougin\Torin\Models\Order|null find(mixed $id)
 * @method \Rougin\Torin\Models\Order[]    get()
 * @method \Rougin\Torin\Models\Order      limit(integer $value)
 * @method \Rougin\Torin\Models\Order      offset(integer $value)
 * @method \Rougin\Torin\Models\Order      with(string|string[] $relations)
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Order extends Model
{
    use SoftDeletes;

    const STATUS_CANCELLED = 2;

    const STATUS_PENDING = 0;

    const STATUS_COMPLETED = 1;

    const TYPE_SALE = 0;

    const TYPE_PURCHASE = 1;

    const TYPE_TRANSFER = 2;

    /**
     * @var string[]
     */
    protected $fillable =
    [
        'client_id',
        'code',
        'remarks',
        'type',
        'status',
    ];

    /**
     * @var string
     */
    protected $connection = 'torin';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return $value ? date('d M Y h:i A', (int) strtotime($value)) : $value;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return $value ? date('d M Y h:i A', (int) strtotime($value)) : $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_order', 'order_id', 'item_id')->withTimestamps();
    }
}
