<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'session_id',
        'clothes_id',
        'jumlah',
    ];

    /**
     * Get the clothes in the shopping cart entry
     */
    public function clothes(): BelongsTo
    {
        return $this->belongsTo(Clothes::class);
    }

}
