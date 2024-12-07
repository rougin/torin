<?php

namespace Rougin\Torin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer      $id
 * @property integer|null $parent_id
 * @property string       $code
 * @property string       $name
 * @property string       $detail
 *
 * @method integer                     count()
 * @method \Rougin\Torin\Models\Item   create(array<string, mixed> $data)
 * @method \Rougin\Torin\Models\Item[] get()
 * @method \Rougin\Torin\Models\Item   limit(integer $value)
 * @method \Rougin\Torin\Models\Item   offset(integer $value)
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Item extends Model
{
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
}
