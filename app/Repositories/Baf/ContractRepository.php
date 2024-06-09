<?php

namespace App\Repositories\Baf;

use Illuminate\Support\Facades\DB;

class ContractRepository
{
    public function list($request, $guid): \Illuminate\Support\Collection
    {
        $q = DB::connection('L1')
            ->table('DOGOVORY_KONTRAGENTOV as d')
            ->select(
                DB::raw('CONVERT(NVARCHAR(max), d.GUID, 1) as guidContract'),
                'd.NAIMENOVANIE as name',
                'd.DATA_NACHALA_DEYSTVIYA as date',
                'd.PROGRAMMA_DOGOVORA as programContract',
                'd.MARZHINALNOST as margin',
                DB::raw('s.NAIMENOVANIE as season'),
                'd.STATUS_PODPISANIYA as signatureStatus',
                'd.SPOSOB_DOSTAVKI as deliveryMethod',
                DB::raw('SUM(d.SUMMA_KZ_TG) as sum')
            )
            ->join('SEZONY as s', 's.GUID', 'd.SEZON_GUID')
            ->where('d.KONTRAGENT_GUID', DB::raw('CAST('.$guid.' AS UNIQUEIDENTIFIER)'));

        if (!empty($request->season)) {
            $q->where('s.NAIMENOVANIE', $this->getSeason($request->season));
        }

        if (!empty($request->year)) {
            $q->where('d.DATA_NACHALA_DEYSTVIYA', 'like', '%'.$request->year.'%');
        }

        $q = $q
            ->groupBy(
                'd.GUID',
                'd.NAIMENOVANIE',
                'd.DATA_NACHALA_DEYSTVIYA',
                's.NAIMENOVANIE',
                'd.PROGRAMMA_DOGOVORA',
                'd.STATUS_PODPISANIYA',
                'd.MARZHINALNOST',
                'd.SPOSOB_DOSTAVKI'
            )->get();

        return $q;
    }

    public function detail($request): \Illuminate\Support\Collection
    {
        $q = DB::connection('L1')
            ->table('SPETSIFIKATSIYA_PO_DOGOVORU as p')
            ->select('p.PERIOD', 'p.VIDY_KULTUR', 'p.KOLICHESTVO', 'p.TSENA', 'n.KATEGORII_NOMENKLATURY_GROUP','p.SUMMA', 'n.NAIMENOVANIE', DB::raw('CONVERT(NVARCHAR(max), p.NOMENKLATURA_GUID, 1) as NOMENKLATURA_GUID'))
            ->join('NOMENKLATURA as n', 'n.GUID', 'p.NOMENKLATURA_GUID')
            ->where('DOGOVOR_GUID', DB::raw('CAST('.$request->guidContract.' AS UNIQUEIDENTIFIER)'))
            ->get();

        return $q;
    }

    public function history($guidContract)
    {
        $q = DB::connection('L1')
            ->table('RASCHETY_S_KLIENTAMI_PO_DOKUMENTAM as rk')
            ->select(DB::raw('SUM(SUMMA_KZT) as sumPaid'))
            ->where('rk.DOGOVOR_GUID', DB::raw('CAST('.$guidContract.' AS UNIQUEIDENTIFIER)'))
            ->whereIn('TIP_DOKUMENTA', [
                'Корректировка реализации',
                'Расчет курсовых разниц',
                'Приходный кассовый ордер',
                'Списание задолженности',
                'Ввод начальных остатков',
                'Поступление безналичных денежных средств',
                'Операция по платежной карте',
                'Взаимозачет задолженности',
                'Списание безналичных денежных средств'
            ])
            ->first();

        return (float)$q->sumPaid ?? 0;
    }

    public function getSeason($season)
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
