<?php 
namespace App\Services;

use Illuminate\Support\Facades\DB;

class ContractService
{
    public function getContracts($guid, $season)
    {
        return DB::connection('L1')
            ->table('DOGOVORY_KONTRAGENTOV as d')
            ->select(DB::raw('...')) // сокращено для краткости
            ->get();
    }

    
}