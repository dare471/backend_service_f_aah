<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;


class bafContractDetail extends JsonResource
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
            'createAt' => $this->PERIOD,
            'product' =>$this->NAIMENOVANIE, 
            'typeCulture' => $this->VIDY_KULTUR,
            'price' => (float)$this->TSENA,
            'category' => $this->KATEGORII_NOMENKLATURY_GROUP,
            'sum' => (float)$this->SUMMA,
            'count' => (float)$this->KOLICHESTVO
        ];
    }

    private function getProduct($guid)
    {
      return DB::connection('L1')
        ->table('NOMENKLATURA')
        ->select('NAIMENOVANIE')
        ->where('GUID', DB::raw('CAST('.$guid.' AS UNIQUEIDENTIFIER)'))
        ->get();
    }

    public function getNameContract($request){
        return DB::connection('L1')
        ->table('DOGOVORY_KONTRAGENTOV')
        ->where('GUID', $request->contractGuid)
        ->get();
        
    }
}
