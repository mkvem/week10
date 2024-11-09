<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    /**
     * Clothes product page
     * @param string $id - clothes id
     * @return void
     */
    public function show(string $id) {
        $clothes = Clothes::query()->where('id', $id)->first();
        return view('productpage', [
            "clothes" => $clothes
        ]);
    }
}
