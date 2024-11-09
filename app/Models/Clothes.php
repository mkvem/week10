<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clothes extends Model
{
    /**
     * Summary of reviews
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(): HasMany {
        return $this->hasMany(Reviews::class);
    }

}
