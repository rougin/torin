<?php

namespace Rougin\Torin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer      $id
 * @property integer|null $parent_id
 * @property string       $code
 * @property string       $name
 * @property string       $detail
 *
 * @method \Rougin\Torin\Models\Item[]    all()
 * @method integer                        count()
 * @method boolean                        delete()
 * @method \Rougin\Torin\Models\Item      create(array<string, mixed> $data)
 * @method \Rougin\Torin\Models\Item      findOrFail(mixed $id)
 * @method \Rougin\Torin\Models\Item|null find(mixed $id)
 * @method \Rougin\Torin\Models\Item[]    get()
 * @method \Rougin\Torin\Models\Item      limit(integer $value)
 * @method \Rougin\Torin\Models\Item      offset(integer $value)
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
     * @param string $value
     *
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return $value ? date('d M Y h:i A', (int) strtotime($value)) : $value;
    }
}
