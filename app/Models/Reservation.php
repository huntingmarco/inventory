<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'idcategory',
        'idroom',
        'date_from',
        'date_to',
        'numrooms',
        'customer_id',
        'phone',
        'email',
        'notes',
        'status',
        'remarks',
        'user'
    ];
}
