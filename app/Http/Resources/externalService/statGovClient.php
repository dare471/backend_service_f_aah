<?php

namespace App\Http\Resources\externalService;

use Illuminate\Http\Resources\Json\JsonResource;

class statGovClient extends JsonResource
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
            'bin' => $this->BIN,
            'fullName' => $this->FIO,
            'orgName' => $this->NAME,
            "okedCode" => $this->OKED_CODE,
            "okedName" => $this->OKED_NAME,
            "secondOkeds" => $this->SECOND_OKEDS,
            "krpCode" => $this->KRP_CODE,
            "katoCode" => $this->KRP_NAME,
            "economicSectorCode" => (float)$this->ECONOMIC_SECTOR_CODE,
            "economcSectorName" => $this->ECONOMIC_SECTOR_NAME,
            "address" => $this->ADDRESS,
            "type" => $this->TYPE,
            "insertedDate" => $this->INSERTED_DATE,
            "versionNumber" => (float)$this->VERSION_NUMBER,
            "registerDate" => $this->REGISTER_DATE,
            "cfoCode" => $this->CFO_CODE,
            "cfoName" => $this->CFO_NAME
        ];
    }
}
