<?php

namespace App\Http\Resources\externalService\Client\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "period" => $this->period,
            "orderSynonym" => $this->synonym_order,
            "orderType" => $this->type_order,
            "orderNumber" => $this->number_order,
            "orderGuid" => $this->order_guid,
            "productName" => $this->name,
            "state" => $this->state,
            "eventsDate" => $this->date_events,
            "count" => (float)$this->count,
            "processingRate" => (float)$this->processing_rate,
            "orderSynonymShipment" => $this->synonym_shipment_order,
            "orderShipmentType" => $this->type_shipment_order,
            "orderShipment" => $this->shipment_order
        ];
    }
}
