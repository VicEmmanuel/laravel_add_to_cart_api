<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Traits\HttpResponses;
use App\Models\CartItem;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use HttpResponses;

    public function index()
    {
        $products = Product::all();

        return $this->success(
            $products,
            'Fetched all products',
        );
    }
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        // Check if the item already exists in the cart
        $cartItem = CartItem::where('product_id', $id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity'); // Increase quantity if item exists
        } else {
            // Create a new cart item
            $cartItem = new CartItem([
                'product_id' => $id,
                'product_name' => $product->product_name,
                'photo' => $product->photo,
                'price' => $product->price,
                'quantity' => 1,
                // $product->is_added_to_cart = true
            ]);
            // $product->is_added_to_cart = true;
            $cartItem->save();
        }
        $product->update(['is_added_to_cart' => true]);
        return $this->success($cartItem, 'Item added to cart');
    }

    public function increaseQuantity($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->increment('quantity');

        return $this->success($cartItem, 'Quantity increased');
    }

    public function decreaseQuantity($id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->delete();
        }

        return $this->success($cartItem, 'Quantity decreased');
    }

    public function getCartItems()
    {
        $cartItems = CartItem::all();

        return response()->json([
            'status' => true,
            'message' => 'Cart items retrieved successfully',
            'data' => $cartItems,
        ]);
    }




    //     public function removeFromCart($id)
    // {
    //     // Find the cart item by its ID
    //     $cartItem = CartItem::find($id);

    //     // Check if the cart item exists
    //     if ($cartItem) {
    //         // Delete the cart item
    //         $cartItem->delete();
    //         return $this->success(null, 'Item removed from cart');
    //     } else {
    //         // If the cart item does not exist, return an error
    //         return $this->error(null, 'Item not found in cart', 404);
    //     }
    // }
    public function removeFromCart($id)
    {
        // Find the cart item by its ID
        $cartItem = CartItem::find($id);

        // Check if the cart item exists
        if ($cartItem) {
            // Get the product associated with the cart item
            $product = Product::find($cartItem->product_id);

            // Update the is_added_to_cart column to false
            $product->update(['is_added_to_cart' => false]);

            // Delete the cart item
            $cartItem->delete();
            return $this->success(null, 'Item removed from cart');
        } else {
            // If the cart item does not exist, return an error
            return $this->error(null, 'Item not found in cart', 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $storeProductRequest)
    {
        $storeProductRequest->validated($storeProductRequest->all());
        $photoPath = $storeProductRequest->file('photo')->store('photos');
        $product = Product::create([

            'product_name' => $storeProductRequest->product_name,
            'product_description' => $storeProductRequest->product_description,
            'photo' => $photoPath,
            'price' => $storeProductRequest->price,
            // 'is_added_to_cart' => $storeProductRequest->is_added_to_cart

        ]);

        return $this->success($product, 'Product Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
