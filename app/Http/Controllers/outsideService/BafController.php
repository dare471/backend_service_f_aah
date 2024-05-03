<?php

namespace App\Http\Controllers\outsideService;

use App\Http\Controllers\Controller;
use App\Http\Resources\bafClient;
use App\Http\Resources\bafContractDetail;
use App\Http\Resources\bafContractList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BafController extends Controller
{
    public function MainRoute(Request $request)
    {
        $type = $request->type;
        if($type == 'findBin')
        {
            return $this->findBin($request);
        }
        if($type == 'listContracts')
        {
            return $this->listContracts($request);
        }
        if($type == 'detailContract')
        {
            return $this->detailContract($request);
        }        
    }

    private function findBin(Request $request)
    {
       $q = DB::connection('L1')
        ->table('KONTRAGENTY')
        ->select('NAIMENOVANIE', 'IIN_BIN', 'FAKT_ADRES_KONTRAGENTA', 'IS_CLIENT', 'BIZNES_REGIONY', DB::raw('CONVERT(NVARCHAR(max), GUID, 1) as GUID'))
        ->where('IIN_BIN', $request->bin)
        ->get();
        //return $q;
        return bafClient::collection($q)->all(); 
    }

    private function listContracts(Request $request)
    {
      
        $q = DB::connection('L1')
        ->table('DOGOVORY_KONTRAGENTOV')
        ->select('NAIMENOVANIE', 'STATUS_PODPISANIYA', 'SPOSOB_DOSTAVKI', 'SUMMA_KZ_TG', DB::raw('CONVERT(NVARCHAR(max), GUID, 1) as GUID'))
        ->where('KONTRAGENT_GUID', $request->guidClient)
        ->get();
        //return $q;
        return bafContractList::collection($q)->all();
    }

    private function detailContract(Request $request)
    {
        $q = DB::connection('L1')
        ->table('SPETSIFIKATSIYA_PO_DOGOVORU as p')
        ->select('p.PERIOD', 'p.VIDY_KULTUR', 'p.KOLICHESTVO', 'p.TSENA', 'n.KATEGORII_NOMENKLATURY_GROUP','p.SUMMA', 'n.NAIMENOVANIE', DB::raw('CONVERT(NVARCHAR(max), p.NOMENKLATURA_GUID, 1) as NOMENKLATURA_GUID'))
        ->join('NOMENKLATURA as n', 'n.GUID', 'p.NOMENKLATURA_GUID')
        ->where('DOGOVOR_GUID', DB::raw('CAST('.$request->guidContract.' AS UNIQUEIDENTIFIER)'))
        ->get();
       //return $q;
        return bafContractDetail::collection($q)->all();
    }
}
