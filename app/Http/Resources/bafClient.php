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
                     DB::raw('SUM(v.SUMMA_VYRUCHKI) as sumV'), 
                     DB::raw('SUM(v.STOIMOST) as sumVV'), 
                     DB::raw('SUM(r.SUMMA_KZT) as sumPaid'), 
                     DB::raw('s.NAIMENOVANIE as season'), 
                     'd.STATUS_PODPISANIYA as signatureStatus', 'd.SPOSOB_DOSTAVKI as deliveryMethod', 
                     DB::raw('SUM(d.SUMMA_KZ_TG) as sum'))
            ->join('RASCHETY_S_KLIENTAMI_PO_DOKUMENTAM as r', 'r.DOGOVOR_GUID', 'd.GUID')
            ->join('SEZONY as s', 's.GUID', 'd.SEZON_GUID')
            ->join('VYRUCHKA_I_SEBESTOIMOST_PRODAZH as v', 'v.DOGOVOR_GUID', 'd.GUID')
            ->where('d.KONTRAGENT_GUID', DB::raw('CAST('.$guid.' AS UNIQUEIDENTIFIER)'))
            ->where('s.NAIMENOVANIE', $this->getSeason($request->season))
            ->whereIn('TIP_DOKUMENTA', ['Корректировка реализации', 'Расчет курсовых разниц', 'Приходный кассовый ордер', 'Списание задолженности', 'Ввод начальных остатков', 'Поступление безналичных денежных средств', 
            'Операция по платежной карте', 'Взаимозачет задолженности', 'Списание безналичных денежных средств'])
            ->groupBy('d.GUID', 'd.NAIMENOVANIE', 's.NAIMENOVANIE', 'd.STATUS_PODPISANIYA', 'd.SPOSOB_DOSTAVKI')
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
