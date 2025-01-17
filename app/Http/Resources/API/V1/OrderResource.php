<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'table_id' => $this->table_id,
            'cashier_id' => $this->cashier_id,
            'order_status' => $this->order_status,
            'order_type' => $this->order_type,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'table' => new TableResource($this->whenLoaded('table')),
            'cashier' => new UserResource($this->whenLoaded('cashier')),
            'order_details' => OrderItemResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}
