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
        $jumlah = $request->jumlah;
        if ($jumlah == 0) {
            return response()->json([
                'result' => "Failed",
                'message' => "Tidak dapat membeli item, jumlah item 0 !"
            ], 403);
        }
        $clothes_id = $request->clothes_id;
        $session_id = $request->session_id;
        $itemInCart = false;

        if (ShoppingCart::query()->where('session_id', $session_id)->where('clothes_id', $clothes_id)->count()){
            $itemInCart = true;
        }

        if ($itemInCart) {
            return response()->json([
                'result' => "Failed",
                'message' => "Item sudah terdapat di cart !"
            ], 403);
        }

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
