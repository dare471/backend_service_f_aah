<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class bafContractListl extends JsonResource
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
            "guidContract" => $this->guidContract,
            "name" => $this->name,
            "signatureStatus" => $this->signatureStatus == "Не подписан" ? false : true,
            "deliveryMethod" => $this->deliveryMethod,
            "sum" => (float)$this->sum,
            "paid" => (float)$this->sumPaid,
            "debt" => (float)$this->sum - (float)$this->sumPaid
        ];
    }
}
