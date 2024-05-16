<?php

namespace App\Http\Services;

use App\Models\outsideService\StatGov;
use Illuminate\Http\Request;

class OutSideClientService
{
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
