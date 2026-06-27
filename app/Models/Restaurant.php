<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'description',
        'address',
        'icon',
        'staff_count',
        'dishes_count',
        'orders_count',
    ];
}
