<?php

namespace Rougin\Torin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer                      $id
 * @property integer|null                 $parent_id
 * @property string                       $code
 * @property string                       $name
 * @property string                       $detail
 * @property \Rougin\Torin\Models\Order[] $orders
 * @property integer                      $quantity
 *
 * @method \Rougin\Torin\Models\Item[]    all()
 * @method \Rougin\Torin\Models\Item      create(array<string, mixed> $data)
 * @method integer                        count()
 * @method boolean                        delete()
 * @method \Rougin\Torin\Models\Item      findOrFail(mixed $id)
 * @method \Rougin\Torin\Models\Item[]    get()
 * @method \Rougin\Torin\Models\Item|null find(mixed $id)
 * @method \Rougin\Torin\Models\Item      limit(integer $value)
 * @method \Rougin\Torin\Models\Item      offset(integer $value)
 * @method \Rougin\Torin\Models\Item      with(string|string[] $relations)
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Item extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable =
    [
        'parent_id',
        'code',
        'name',
        'detail',
    ];

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
     * @return integer
     */
    public function getQuantityAttribute()
    {
        $quantity = 0;

        foreach ($this->orders as $order)
        {
            if ($order->type !== Order::TYPE_SALE)
            {
                // TODO: Check how to type-hint "pivot" ---
                $quantity += $order->pivot->quantity;
                // ----------------------------------------
            }
        }
        return $quantity;
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
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'item_order', 'item_id', 'order_id')->withPivot('quantity');
    }
}
