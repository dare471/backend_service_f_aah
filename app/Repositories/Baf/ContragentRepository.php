<?php

namespace App\Repositories\Baf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContragentRepository
{
    public function search(Request $request): \Illuminate\Support\Collection
    {
        $q = DB::connection('L1')
            ->table('KONTRAGENTY')
            ->select('NAIMENOVANIE', 'IIN_BIN', 'FAKT_ADRES_KONTRAGENTA', 'IS_CLIENT', 'BIZNES_REGIONY', DB::raw('CONVERT(NVARCHAR(max), GUID, 1) as GUID'))
            ->where('IIN_BIN', $request->bin)
            ->get();

        return $q;
    }
    public function getClientBin($request): \Illuminate\Support\Collection
    {
        $q = \DB::connection('__ExternalData')
            ->table('REF_STAT_GOV_CLIENT_INFO')
            ->whereIn('BIN', $request->bins)
            ->get();
        return $q;
    }
}
