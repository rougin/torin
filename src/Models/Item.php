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
 * @property string                       $created_at
 * @property string|null                  $updated_at
 *
 * @method \Rougin\Torin\Models\Item[]    all()
 * @method \Rougin\Torin\Models\Item      create(array<string, mixed> $data)
 * @method integer                        count()
 * @method boolean                        delete()
 * @method \Rougin\Torin\Models\Item      findOrFail(mixed $id)
 * @method \Rougin\Torin\Models\Item|null first()
 * @method \Rougin\Torin\Models\Item[]    get()
 * @method \Rougin\Torin\Models\Item|null find(mixed $id)
 * @method \Rougin\Torin\Models\Item      limit(integer $value)
 * @method \Rougin\Torin\Models\Item      offset(integer $value)
 * @method \Rougin\Torin\Models\Item      where(mixed $field, mixed ...$args)
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
     * @var array<string, string>
     */
    protected $casts =
    [
        'parent_id' => 'integer',
    ];

    /**
     * @var array<integer, string>
     */
    protected $fillable =
    [
        'parent_id',
        'code',
        'name',
        'detail',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $connection = 'torin';

    /**
     * @return array<string, mixed>
     */
    public function asRow()
    {
        $row = array('id' => $this->id);

        $row['code'] = $this->code;

        $row['name'] = $this->name;

        $row['quantity'] = $this->quantity;

        $row['detail'] = $this->detail;

        $row['created_at'] = $this->created_at;

        $row['updated_at'] = $this->updated_at;

        return $row;
    }

    /**
     * @return array<string, mixed>
     */
    public function asSelect()
    {
        $row = array();

        $row['value'] = $this->id;
        $row['label'] = $this->name;

        return $row;
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
     * @return integer
     */
    public function getQuantityAttribute()
    {
        $total = 0;

        foreach ($this->orders as $order)
        {
            if ($order->status !== Order::STATUS_COMPLETED)
            {
                continue;
            }

            // @phpstan-ignore-next-line ----
            $value = $order->pivot->quantity;
            // ------------------------------

            if ($order->type === Order::TYPE_SALE)
            {
                $total = $total - $value;

                continue;
            }

            $total = $total + $value;
        }

        return $total;
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
