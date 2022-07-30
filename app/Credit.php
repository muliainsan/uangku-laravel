<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use Sortable;

    /**
     * @var string
     */
    protected $table = 'credit';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'category_id', 'nominal', 'description', 'credit_date'
    ];

    public $sortable = ['category_id', 'nominal', 'description', 'credit_date'];
}