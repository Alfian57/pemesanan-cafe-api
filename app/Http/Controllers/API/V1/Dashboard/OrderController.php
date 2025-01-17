<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'filter[order_status]' => ['nullable', 'string', 'in:pending,completed,cancelled'],
            'filter[order_type]' => ['nullable', 'string', 'in:dine-in,take-away'],
            'filter[payment_status]' => ['nullable', 'string', 'in:unpaid,paid'],
            'filter[payment_method]' => ['nullable', 'string', 'in:cash,via-web'],
            'sort' => ['nullable', 'string', 'in:created_at,-created_at'],
            'page[number]' => ['nullable', 'integer', 'min:1'],
            'page[size]' => ['nullable', 'integer', 'min:1'],
        ]);

        $orders = QueryBuilder::for(Order::class)
            ->allowedFilters(['order_status', 'order_type', 'payment_status', 'payment_method'])
            ->allowedSorts(['created_at'])
            ->allowedIncludes(['customer', 'table', 'cashier'])
            ->jsonPaginate();

        return OrderResource::collection($orders);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('customer', 'table', 'cashier', 'orderItems.menu');

        return OrderResource::make($order);
    }
}
