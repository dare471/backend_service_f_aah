<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractService
{
    public function listContracts(Request $request)
    {
        $q = DB::connection('L1')
            ->table('DOGOVORY_KONTRAGENTOV')
            ->select('NAIMENOVANIE as name', 'STATUS_PODPISANIYA as signatureStatus', 'SPOSOB_DOSTAVKI as deliveryMethod', 'PROGRAMMA_DOGOVORA as programContract', 'SUMMA_KZ_TG as sum', DB::raw('CONVERT(NVARCHAR(max), GUID, 1) as guidContract'))
            ->where('KONTRAGENT_GUID', DB::raw('CAST('.$request->guidClient.' AS UNIQUEIDENTIFIER)'))
            ->get();

        return $q;
    }
    public function detailContract(Request $request)
    {
        $q = DB::connection('L1')
            ->table('SPETSIFIKATSIYA_PO_DOGOVORU as p')
            ->select('p.PERIOD', 'p.VIDY_KULTUR', 'p.KOLICHESTVO', 'p.TSENA', 'n.KATEGORII_NOMENKLATURY_GROUP','p.SUMMA', 'n.NAIMENOVANIE', DB::raw('CONVERT(NVARCHAR(max), p.NOMENKLATURA_GUID, 1) as NOMENKLATURA_GUID'))
            ->join('NOMENKLATURA as n', 'n.GUID', 'p.NOMENKLATURA_GUID')
            ->where('DOGOVOR_GUID', DB::raw('CAST('.$request->guidContract.' AS UNIQUEIDENTIFIER)'))
            ->get();

        return $q;
    }

    public function getHistoryOperation($guidContract)
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

    public function getProduct($guid)
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
