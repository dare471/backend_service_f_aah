<?php

namespace App\Http\Resources\externalService;

use Illuminate\Http\Resources\Json\JsonResource;

class bafContractDetail extends JsonResource
{
    public function toArray($request)
    {
        return [
            'period' => $this->PERIOD,
            'cropType' => $this->VIDY_KULTUR,
            'quantity' => (float)$this->KOLICHESTVO,
            'price' => (float)$this->TSENA,
            'category' => $this->KATEGORII_NOMENKLATURY_GROUP,
            'sum' => (float)$this->SUMMA,
            'itemName' => $this->NAIMENOVANIE,
            'guidItem' => (string)$this->NOMENKLATURA_GUID
        ];
    }
}
