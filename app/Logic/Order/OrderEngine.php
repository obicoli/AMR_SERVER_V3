<?php

namespace App\Logic\Order;



use App\Models\Product\Order\Order;
use App\Models\Product\Product;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class OrderEngine
{
    protected $model;

    protected $user;

    protected $product;


    public function __construct(Order $order, User $user, Product $product)
    {
        $this->model = $order;
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * @param Request $request
     */
    public static function initializeOrder(Request $request)
    {
        $data = $request->except("_token");
        $buyer = auth()->user()->role;
        $owner_type = "";

        switch ($buyer) {
            case "doctor":
               // $owner_type = "give path to the matching class";
                break;
        }
        $order = Order::query()->create([
            "owner_id" => auth()->user()->id,
            "owner_type" => $owner_type,
        ]);

        $order->order_item()->create($request->items);

        self::process_order($order);
    }

    private function process_order($order)
    {
        //check if paid,
        //check delivery,
        //check payment method
        //send notifications
        //
    }
}
