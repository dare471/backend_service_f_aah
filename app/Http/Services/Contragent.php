<?php

namespace App\Http\Services;

use App\Models\outsideService\StatGov;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class  Contragent
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
    public function getClient(Request  $request){
        $q = \DB::connection('__ExternalData')
            ->table('REF_STAT_GOV_CLIENT_INFO')
            ->whereIn('BIN', $request->bins)
            ->get();
        return $q;
    }
    public function setClient(Request $request)
    {
        $validatedData = $request->validate([
            'bins' => 'required|string',
        ]);
        $q = StatGov::create($validatedData);
        return $q;
    }

}
