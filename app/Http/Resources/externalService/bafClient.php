<?php

namespace App\Http\Resources\externalService;

use App\Services\Baf\ContractService;
use Illuminate\Http\Resources\Json\JsonResource;

class bafClient extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->NAIMENOVANIE,
            'bin' => $this->IIN_BIN,
            'addres' => $this->FAKT_ADRES_KONTRAGENTA,
            'isClient' => $this->IS_CLIENT,
            'buissnesRegion' => $this->BIZNES_REGIONY,
            'guidClient' => (string)$this->GUID,
            'contractCount' => $this->contractList($request, $this->GUID)->count(),
            'contractList' => bafContractList::collection($this->contractList($request, $this->GUID))
        ];
    }

    private function contractList($request, $guid)
    {
        return app(ContractService::class)->listContracts($request, $guid);
    }
}
