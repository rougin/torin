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
 * @property string       $created_at
 * @property string|null  $updated_at
 *
 * @method \Rougin\Torin\Models\Client[]    all()
 * @method integer                          count()
 * @method boolean                          delete()
 * @method \Rougin\Torin\Models\Client      create(array<string, mixed> $data)
 * @method \Rougin\Torin\Models\Client      findOrFail(mixed $id)
 * @method \Rougin\Torin\Models\Client|null find(mixed $id)
 * @method \Rougin\Torin\Models\Client|null first()
 * @method \Rougin\Torin\Models\Client[]    get()
 * @method \Rougin\Torin\Models\Client      limit(integer $value)
 * @method \Rougin\Torin\Models\Client      offset(integer $value)
 * @method \Rougin\Torin\Models\Client      where(mixed $field, mixed ...$args)
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
     * @var array<string, string>
     */
    protected $casts =
    [
        'parent_id' => 'integer',
        'type' => 'integer',
    ];

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
        'created_at',
        'updated_at',
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
