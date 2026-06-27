<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'street',
        'city',
        'postal_code',
        'notes',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
