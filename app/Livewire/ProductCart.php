<?php

namespace App\Livewire;

use App\Models\Price;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Modules\Setting\Entities\Unit;

class ProductCart extends Component
{

    public $listeners = ['productSelected', 'discountModalRefresh'];
    public $iterate = 0;
    public $cart_instance;
    public $global_discount;
    public $global_tax;
    public $shipping;
    public $quantity;
    public $check_quantity;
    public $discount_type;
    public $item_discount;
    public $unit_price;
    public $data;
    public $qty = 1;




    private $product;

    public function mount($cartInstance, $data = null)
    {
        $this->cart_instance = $cartInstance;


        if ($data) {
            $this->data = $data;

            $this->global_discount = $data->discount_percentage;
            $this->global_tax = $data->tax_percentage;
            $this->shipping = $data->shipping_amount;

            $this->updatedGlobalTax();
            $this->updatedGlobalDiscount();

            $cart_items = Cart::instance($this->cart_instance)->content();

            foreach ($cart_items as $cart_item) {
                $this->check_quantity[$cart_item->id] = [$cart_item->options->stock];
                $this->quantity[$cart_item->id] = $cart_item->qty;
                $this->unit_price[$cart_item->id] = $cart_item->price;
                $this->discount_type[$cart_item->id] = $cart_item->options->product_discount_type;
                if ($cart_item->options->product_discount_type == 'fixed') {
                    $this->item_discount[$cart_item->id] = $cart_item->options->product_discount;
                } elseif ($cart_item->options->product_discount_type == 'percentage') {
                    $this->item_discount[$cart_item->id] = round(100 * ($cart_item->options->product_discount / $cart_item->price));
                }
            }
        } else {
            $this->global_discount = 0;
            $this->global_tax = 0;
            $this->shipping = 0.00;
            $this->check_quantity = [];
            $this->quantity = [];
            $this->unit_price = [];
            $this->discount_type = [];
            $this->item_discount = [];
        }
    }

    public function render()
    {
        $cart_items = Cart::instance($this->cart_instance)->content();

        return view('livewire.product-cart', [
            'cart_items' => $cart_items
        ]);
    }

    public function productSelected($stock)
    {
        $product = Product::find($stock['product_id']);
        $cart = Cart::instance($this->cart_instance);

        $exists = $cart->search(function ($cartItem, $rowId) use ($stock) {
            return $cartItem->id == $stock['id'];
        });

        if ($exists->isNotEmpty()) {
            //  dd('This is good');
        }

        $this->product = $product;

      
        $unit = Unit::find($stock['unit_id']);
        $price_value = Price::where('stock_id', $stock['id'])->first();
        // dd($unit);
        // Prepare price options
       
        // Add product to cart with prices options
        $cart->add([
            'id'      => $stock['id'],
            'name'    => $product['product_name'],
            'qty'     => 1,
            'price'   => $this->calculate($product)['price'],
            // 'unit'   => $product['product_name'],
            // 'unit_price' =>$product['unit_price'],
            'weight'  => 1,
            'options' => [
                // 'product_discount'      => 0.00,
                // 'product_discount_type' => 'fixed',
                // 'code'                  => $product['product_code'],
                'selected_quantity'             => $this->qty,
                'sub_total'             => $price_value->product_price * 1,
                'stock'                 => $stock['product_quantity'],
                'product_id'                 => $product['id'],
                'unit'                  => $unit->name,
                'unit_id'                  => $unit->id,
                'price_value'           => $price_value->product_price,
                'sale_id' => 1,
                'price_id'           => $price_value->id,
                'product_tax'           => $this->calculate($product)['product_tax'],
                'unit_price'            => $this->calculate($product)['unit_price'],
              
            ]
        ]);

        // $this->check_quantity[$product['id']] = $product['product_quantity'];
        $this->quantity[$product['id']] = 1;
        $this->discount_type[$product['id']] = 'fixed';
        $this->item_discount[$product['id']] = 0;
    }

    public function removeItem($row_id)
    {
        Cart::instance($this->cart_instance)->remove($row_id);
    }

    public function updatedGlobalTax()
    {
        Cart::instance($this->cart_instance)->setGlobalTax((int)$this->global_tax);
    }

    public function updatedGlobalDiscount()
    {
        Cart::instance($this->cart_instance)->setGlobalDiscount((int)$this->global_discount);
    }

    
    public function updateQuantity($productId, $quantity)
    {

        $this->qty = $quantity;
        // dd($quantity);
        // Find the cart item by its product ID
        $cart_item = Cart::instance($this->cart_instance)->search(function ($cartItem, $rowId) use ($productId) {
            return $cartItem->id === $productId;
        })->first();
        dd($this->qty);
        // // Update the quantity of the item in the cart
        // if ($cart_item) {
        //     Cart::instance($this->cart_instance)->update($cart_item->rowId, $quantity);
        // }

        // $sub_total = $cart_item->options->unit_price * $quantity;
        // // Update the cart item options
        // if ($cart_item) {
        //     Cart::instance($this->cart_instance)->update($cart_item->rowId, [
        //         'options' => [
        //             'sub_total' => $sub_total,
        //             'stock'     => $cart_item->options->stock,
        //             // Add other options here if needed
        //         ]
        //     ]);
        // }
    }


    public function updatedDiscountType($value, $name)
    {
        $this->item_discount[$name] = 0;
    }

    public function discountModalRefresh($product_id, $row_id)
    {
        $this->updateQuantity($row_id, $product_id);
    }

    public function setProductDiscount($row_id, $product_id)
    {
        $cart_item = Cart::instance($this->cart_instance)->get($row_id);

        if ($this->discount_type[$product_id] == 'fixed') {
            Cart::instance($this->cart_instance)
                ->update($row_id, [
                    'price' => ($cart_item->price + $cart_item->options->product_discount) - $this->item_discount[$product_id]
                ]);

            $discount_amount = $this->item_discount[$product_id];

            $this->updateCartOptions($row_id, $product_id, $cart_item, $discount_amount);
        } elseif ($this->discount_type[$product_id] == 'percentage') {
            $discount_amount = ($cart_item->price + $cart_item->options->product_discount) * ($this->item_discount[$product_id] / 100);

            Cart::instance($this->cart_instance)
                ->update($row_id, [
                    'price' => ($cart_item->price + $cart_item->options->product_discount) - $discount_amount
                ]);

            $this->updateCartOptions($row_id, $product_id, $cart_item, $discount_amount);
        }

        session()->flash('discount_message' . $product_id, 'Discount added to the product!');
    }

    public function updatePrice($row_id, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $cart_item = Cart::instance($this->cart_instance)->get($row_id);

        Cart::instance($this->cart_instance)->update($row_id, ['price' => $this->unit_price[$product['id']]]);

        Cart::instance($this->cart_instance)->update($row_id, [
            'options' => [
                'sub_total'             => $this->calculate($product, $this->unit_price[$product['id']])['sub_total'],
                'code'                  => $cart_item->options->code,
                'stock'                 => $cart_item->options->stock,
                'unit'                  => $cart_item->options->unit,
                'product_tax'           => $this->calculate($product, $this->unit_price[$product['id']])['product_tax'],
                'unit_price'            => $this->calculate($product, $this->unit_price[$product['id']])['unit_price'],
                'product_discount'      => $cart_item->options->product_discount,
                'product_discount_type' => $cart_item->options->product_discount_type,
            ]
        ]);
    }

    public function calculate($product, $new_price = null)
    {
        if ($new_price) {
            $product_price = $new_price;
        } else {
            // $this->unit_price[$product['id']] = $product['product_price'];
            if ($this->cart_instance == 'purchase' || $this->cart_instance == 'purchase_return') {
                $this->unit_price[$product['id']] = $product['product_cost'];
            }
            // $product_price = $this->unit_price[$product['id']];
        }
        $price = 0;
        $unit_price = 0;
        $product_tax = 0;
        $sub_total = 0;

        // if ($product['product_tax_type'] == 1) {
        //     $price = $product_price + ($product_price * ($product['product_order_tax'] / 100));
        //     $unit_price = $product_price;
        //     $product_tax = $product_price * ($product['product_order_tax'] / 100);
        //     $sub_total = $product_price + ($product_price * ($product['product_order_tax'] / 100));
        // } elseif ($product['product_tax_type'] == 2) {
        //     $price = $product_price;
        //     $unit_price = $product_price - ($product_price * ($product['product_order_tax'] / 100));
        //     $product_tax = $product_price * ($product['product_order_tax'] / 100);
        //     $sub_total = $product_price;
        // } else {
        //     $price = $product_price;
        //     $unit_price = $product_price;
        //     $product_tax = 0.00;
        //     $sub_total = $product_price;
        // }

        return ['price' => $price, 'unit_price' => $unit_price, 'product_tax' => $product_tax, 'sub_total' => $sub_total];
    }

    public function updateCartOptions($row_id, $product_id, $cart_item)
    {
        Cart::instance($this->cart_instance)->update($row_id, ['options' => [
            'sub_total'             => $cart_item->options->product_price * $cart_item->qty,

        ]]);
    }
}
