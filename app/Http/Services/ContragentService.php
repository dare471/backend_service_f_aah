<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class  ContragentService
{
    public function findBin(Request $request)
    {
        $q = DB::connection('L1')
            ->table('KONTRAGENTY')
            ->select('NAIMENOVANIE', 'IIN_BIN', 'FAKT_ADRES_KONTRAGENTA', 'IS_CLIENT', 'BIZNES_REGIONY', DB::raw('CONVERT(NVARCHAR(max), GUID, 1) as GUID'))
            ->where('IIN_BIN', $request->bin)
            ->get();

        return $q;
    }

    public function contractList(Request $request, $guid)
    {
        $q = DB::connection('L1')
            ->table('DOGOVORY_KONTRAGENTOV as d')
            ->select(
                DB::raw('CONVERT(NVARCHAR(max), d.GUID, 1) as guidContract'),
                'd.NAIMENOVANIE as name',
                'd.DATA_NACHALA_DEYSTVIYA as date',
                'd.PROGRAMMA_DOGOVORA as programContract',
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
                'd.SPOSOB_DOSTAVKI'
            )->get();

        return $q;
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
