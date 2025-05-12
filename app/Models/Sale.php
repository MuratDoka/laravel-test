<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'quantity', 'unit_cost', 'cost', 'selling_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
