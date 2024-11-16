<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function addToCart(Request $request) {
        $clothes_id = $request->clothes_id;
        $jumlah = $request->jumlah;
        $session_id = $request->session_id;

        ShoppingCart::create([
            'session_id' => $session_id,
            'clothes_id' => $clothes_id,
            'jumlah' => $jumlah,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return response()->json([
            'result' => "Success",
            'message' => "Item berhasil ditambahkan ke cart !"
        ]);
    }

    public function deleteFromShoppingCart(Request $request) {
        $id = $request->id;
        ShoppingCart::query()->where('id', $id)->delete();

        return response()->json([
            'result' => "Success",
            'message' => "Item berhasil dihapus !"
        ]);
    }
}
