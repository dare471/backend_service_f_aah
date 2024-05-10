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
            'contractCount' => $this->contractList($request, $this->GUID)->count(),
            'contractList' => $this->contractList($request, $this->GUID)
        ];
    }

    private function contractList($request, $guid)
    {
        $q = DB::connection('L1')
            ->table('DOGOVORY_KONTRAGENTOV as d')
            ->select(DB::raw('CONVERT(NVARCHAR(max), d.GUID, 1) as guidContract'), 'd.NAIMENOVANIE as name',
                     'd.DATA_NACHALA_DEYSTVIYA as date', 
                     DB::raw('SUM(r.SUMMA_KZT) as sumPaid'), 
                     DB::raw('s.NAIMENOVANIE as season'), 
                     'd.STATUS_PODPISANIYA as signatureStatus', 'd.SPOSOB_DOSTAVKI as deliveryMethod', 
                     DB::raw('SUM(d.SUMMA_KZ_TG) as sum'),
                     DB::raw('TIP_DOKUMENTA as documentType')
                     )
            ->leftJoin('RASCHETY_S_KLIENTAMI_PO_DOKUMENTAM as r', 'r.DOGOVOR_GUID', 'd.GUID')
            ->join('SEZONY as s', 's.GUID', 'd.SEZON_GUID')
            ->where('d.KONTRAGENT_GUID', DB::raw('CAST('.$guid.' AS UNIQUEIDENTIFIER)'));
    
        if (!empty($request->season)) {
            $q->where('s.NAIMENOVANIE', $this->getSeason($request->season));
        }
    
        if (!empty($request->year)) {
            $q->where('d.DATA_NACHALA_DEYSTVIYA', 'like', '%'.$request->year.'%');
        }
    
        $q = $q->groupBy('d.GUID', 'd.NAIMENOVANIE', 'r.TIP_DOKUMENTA', 'd.DATA_NACHALA_DEYSTVIYA', 's.NAIMENOVANIE', 'd.STATUS_PODPISANIYA', 'd.SPOSOB_DOSTAVKI')
              ->get();
    
        return bafContractListl::collection($q);
    }
    
    
    private function getSeason($season)
    {
        switch ($season) {
            case "2017":
                return "Сезон 2017";
                break;
            case "2018":
                return "Сезон 2018";
                break;
            case "2019":
                return "Сезон 2019";
                break;
            case "2020":
                return  "Сезон 2020";
                break;
            case "2021":
                return "Сезон 2021";
                break;
            case "2022":
                return "Сезон 2022";
                break;
            case "2023":
                return  "Сезон 2023";
                break;
            case "2024":
                return "Сезон 2024";
                break;
            case "2025":
                return "Сезон 2025";
                break;
            default:
                return "Сезон не определен";
        }
    }

}
