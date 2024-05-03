<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class bafClient extends JsonResource
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
            'name' => $this->NAIMENOVANIE,
            'bin' => $this->IIN_BIN,
            'addres' => $this->FAKT_ADRES_KONTRAGENTA,
            'isClient' => $this->IS_CLIENT,
            'buissnesRegion' => $this->BIZNES_REGIONY,
            'guidClient' => (string)$this->GUID,
            'contractCount' => $this->contractList($this->GUID)->count(),
            'contractList' => $this->contractList($this->GUID)
        ];
    }

    private function contractList($guid){
        $q = DB::connection('L1')
            ->table('DOGOVORY_KONTRAGENTOV')
            ->select( DB::raw('CONVERT(NVARCHAR(max), GUID, 1) as guidContract'), 'NAIMENOVANIE as name', 'STATUS_PODPISANIYA as signatureStatus', 'SPOSOB_DOSTAVKI as deliveryMethod', 'SUMMA_KZ_TG as sum',)
            ->where('KONTRAGENT_GUID', DB::raw('CAST('.$guid.' AS UNIQUEIDENTIFIER)'))
            ->get();
        return bafContractListl::collection($q);
    }

}
