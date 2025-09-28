<?php

namespace Rougin\Torin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer      $id
 * @property integer      $type
 * @property integer|null $parent_id
 * @property string       $code
 * @property string       $name
 * @property string       $remarks
 *
 * @method \Rougin\Torin\Models\Client[]    all()
 * @method integer                          count()
 * @method boolean                          delete()
 * @method \Rougin\Torin\Models\Client      create(array<string, mixed> $data)
 * @method \Rougin\Torin\Models\Client      findOrFail(mixed $id)
 * @method \Rougin\Torin\Models\Client|null find(mixed $id)
 * @method \Rougin\Torin\Models\Client[]    get()
 * @method \Rougin\Torin\Models\Client      limit(integer $value)
 * @method \Rougin\Torin\Models\Client      offset(integer $value)
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Client extends Model
{
    use SoftDeletes;

    const TYPE_CUSTOMER = 0;

    const TYPE_SUPPLIER = 1;

    /**
     * @var array<integer, string>
     */
    protected $fillable =
    [
        'parent_id',
        'code',
        'name',
        'remarks',
        'type',
        'email',
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
     * @param string $value
     *
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return $value ? date('d M Y h:i A', (int) strtotime($value)) : $value;
    }
}
