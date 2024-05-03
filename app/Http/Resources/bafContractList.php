<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class bafContractList extends JsonResource
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
            'contractName' => $this->NAIMENOVANIE,
            'signStatus' => $this->STATUS_PODPISANIYA,
            'deliveryMethod' => $this->SPOSOB_DOSTAVKI,
            'summary' => (float)$this->SUMMA_KZ_TG,
            'guidContract' => (string)$this->GUID
        ];
    }
}
