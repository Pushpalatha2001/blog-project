<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;  
use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Orders_Items;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function ProductAll()
    {
        $data = [];
        $data['page_title'] = 'Product All';

        $product = Product::all();
        return view('backend.product.all', compact('data','product'))->with('page_title', $data['page_title']);
    }

    public function ProductAdd()
    {
        $data = [];
        $data['page_title'] = 'Product Add';
        return view('backend.product.add', compact('data'))->with('page_title', $data['page_title']);
    }
    public function ProductStore(Request $request)
    {
        
        Product::create([
            'name' => $request->name,
            'description' =>$request->description, 
            'price' => $request->price,            
            'stock' => $request->stock,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);
         $notification = array(
            'message' => 'Product Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('product_all')->with($notification); 
    }
    public function ProductEdit($id)
    {
        $data = [];
        $data['page_title'] = 'Product - ' . $id;

        $product = Product::findOrFail($id);

        return view('backend.product.edit', compact('product', 'data'))->with('page_title', $data['page_title']);
    }

    public function ProductUpdate(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $product->update([
            'name' => $request->name,
            'description' => $request->description, 
            'price' => $request->price,  
            'stock' => $request->stock, 
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Product Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('product_all')->with($notification); 
    }
public function OrderAll()
{
    $data = [];
    $data['page_title'] = 'All Orders';
    $orders = Orders::with('user','orderItems','orderItems.product')->latest()->get();

    return view('backend.order.all', compact('orders', 'data'))->with('page_title', $data['page_title']);
}
public function OrderAdd()
{
    $data = [];
    $data['page_title'] = 'Create Order';

    $products = Product::where('stock', '>', 0)->get();

    return view('backend.order.add', compact('data', 'products'))->with('page_title', $data['page_title']);
}
public function OrderStore(Request $request)
{
    DB::beginTransaction(); 

    try {
        $totalPrice = 0;
        $items = [];

        foreach ($request->product_ids as $index => $productId) {
            $product = Product::findOrFail($productId);
            $quantity = $request->quantities[$index];

            if ($quantity > 0) {
                if ($product->stock < $quantity) {
                    return back()->with('error', 'Insufficient stock for ' . $product->name);
                }

                $totalPrice += $product->price * $quantity;

                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }

        if (empty($items)) {
            return back()->with('error', 'Please select at least one product.');
        }

        $order = Orders::create([
            'user_id' => Auth::user()->id,
            'total_price' => $totalPrice,
            'status' => 0,
        ]);

        foreach ($items as $item) {

            Orders_Items::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['product']->price,
            ]);
            $item['product']->decrement('stock', $item['quantity']);
        }

        DB::commit(); 

        return redirect()->route('order_all')->with('message', 'Order placed successfully!');
    } catch (\Exception $e) {
        DB::rollBack(); 
        return back()->with('error', 'Order failed: ' . $e->getMessage());
    }
}
}
