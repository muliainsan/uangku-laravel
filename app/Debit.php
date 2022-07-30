<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Debit extends Model
{
    use Sortable;
    /**
     * @var string
     */
    protected $table = 'debit';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'category_id', 'nominal', 'description', 'debit_date'
    ];

    public $sortable = ['category_id', 'nominal', 'description', 'debit_date'];
}