<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ShoppingController extends Controller
{
    /**
     * Page for showing all products (clothes)
     * @return void
     */
    public function showAllProducts() {
        $listClothes = Clothes::query()->get();
        return view('index', [
            "listClothes" => $listClothes
        ]);
    }

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

    public function checkOut() {
        $listCartItems = ShoppingCart::with('clothes')
                                    ->where('session_id', Session::getId())
                                    ->get();
        return view('checkout', [
            "listCartItems" => $listCartItems
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

    public function updateCartItemQty(Request $request) {
        /**
         * API to update cart item qty
         * Parameters:
         * session_id => session_id dari client
         * id => id yang ada di table shopping_carts
         * jumlah => jumlah qty baru untuk item
         * 
         * Response:
         * 200 => Success, jumlah item di shopping cart sukses terupdate
         * 403 => Forbidden
         * - Parameter jumlah = 0
         * - Parameter id tidak ditemukan di tabel shopping_carts
         * 400 => Bad Request
         * - Session id tidak sesuai dengan yang terdaftar di table shopping_carts
         */
        $jumlah = $request->jumlah;
        if ($jumlah == 0) {
            return response()->json([
                'result' => "Failed",
                'message' => "Tidak dapat update jumlah item menjadi 0 !"
            ], 403);
        }
        $id = $request->id;
        $session_id = $request->session_id;

        // Get shopping cart item dengan id dari request API
        $cartItem = ShoppingCart::query()
                        ->where('id', $id)
                        ->firstOrFail();
        
        // Jika id dari request API tidak ada di tabel shopping_carts
        if(!$cartItem) {
            return response()->json([
                'result' => "Failed",
                'message' => "Data tidak ditemukan !"
            ], 403);
        }
        // Jika session id dari request API tidak sesuai dengan yang di tabel shopping_carts
        if($cartItem->session_id != $session_id) {
            return response()->json([
                'result' => "Failed",
                'message' => "Bad request data, session not valid"
            ], 400);
        }

        ShoppingCart::query()->where('id', $id)->update([
            'jumlah' => $jumlah,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        return response()->json([
            'result' => "Success",
            'message' => "Jumlah item ".$cartItem->clothes->name." berhasil diupdate di shopping cart !"
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
