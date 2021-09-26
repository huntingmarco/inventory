<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acctgroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'grouptype'
    ];
 
}
