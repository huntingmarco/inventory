<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acctitem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'item_name',
        'group_id',
        'debit',
        'credit',
        'bal'
    ];
}
