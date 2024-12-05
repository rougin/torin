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
 * @method \Rougin\Torin\Models\Item create(array<string, mixed> $data)
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
