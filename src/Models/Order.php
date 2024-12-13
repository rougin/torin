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
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Order extends Model
{
    use SoftDeletes;

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
     * @param string $value
     *
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return $value ? date('d M Y h:i:s A', (int) strtotime($value)) : $value;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return $value ? date('d M Y h:i:s A', (int) strtotime($value)) : $value;
    }
}
