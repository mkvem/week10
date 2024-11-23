<?php

use App\Http\Controllers\ShoppingController;
use App\Http\Resources\ShoppingCartResource;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Route;

// Page showing all products
Route::get('/',[ShoppingController::class, 'showAllProducts'])->name('showallproducts');

// Page showing certain product
Route::get('/product/details/{id}', [ShoppingController::class, 'show'])->name('productpage');

// Page showing check out summary
Route::get('/checkout',[ShoppingController::class, 'checkOut'])->name('checkout');

/**
 * Get Shopping Cart Items API
 */
Route::get('/shoppingcart/{sessionid}', function(string $sessionid) {
    $listItems = ShoppingCart::with('clothes')
                            ->where('session_id', $sessionid)
                            ->get();
    return ShoppingCartResource::collection($listItems);
});

/**
 * POST - API untuk add to Cart
 */
Route::post('/addtocart',[ShoppingController::class, 'addToCart'])->name('addtocart');

/**
 * POST - API untuk update item QTY in Cart
 */
Route::post('/updatecartitemqty',[ShoppingController::class, 'updateCartItemQty'])->name('updatecartitemqty');

/**
 * POST - API untuk delete from cart
 */
Route::post('/deletefromshoppingcart',[ShoppingController::class, 'deleteFromShoppingCart'])->name('deletefromshoppingcart');