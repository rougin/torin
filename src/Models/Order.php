<?php

namespace Rougin\Torin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer                     $id
 * @property integer|null                $client_id
 * @property string                      $code
 * @property string                      $remarks
 * @property integer                     $type
 * @property integer                     $status
 * @property string                      $created_at
 * @property string|null                 $updated_at
 * @property \Rougin\Torin\Models\Item[] $items
 *
 * @method \Rougin\Torin\Models\Order[]    all()
 * @method integer                         count()
 * @method boolean                         delete()
 * @method \Rougin\Torin\Models\Order      create(array<string, mixed> $data)
 * @method \Rougin\Torin\Models\Order      findOrFail(mixed $id)
 * @method \Rougin\Torin\Models\Order|null find(mixed $id)
 * @method \Rougin\Torin\Models\Order[]    get()
 * @method \Rougin\Torin\Models\Order      limit(integer $value)
 * @method \Rougin\Torin\Models\Order      offset(integer $value)
 * @method \Rougin\Torin\Models\Order      where(mixed $field, mixed ...$args)
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
     * @var array<string, string>
     */
    protected $casts = array(

        'client_id' => 'integer',
        'type' => 'integer',
        'status' => 'integer',

    );

    /**
     * @var array<integer, string>
     */
    protected $fillable = array(

        'client_id',
        'code',
        'remarks',
        'type',
        'status',
        'created_at',
        'updated_at',

    );

    /**
     * @var string
     */
    protected $connection = 'torin';

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
        $class = 'Rougin\Torin\Models\Item';

        return $this->belongsToMany($class, 'item_order', 'order_id', 'item_id')
            ->withTimestamps();
    }
}
