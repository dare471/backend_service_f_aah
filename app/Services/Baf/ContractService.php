<?php

namespace App\Services\Baf;

use App\Repositories\Baf\ContractRepository;
use Illuminate\Http\Request;

class ContractService
{
    protected  $contractRepo;
    public function __construct(ContractRepository $contractRepo)
    {
        $this->contractRepo = $contractRepo;
    }

    public function listContracts(Request $request, $guid): \Illuminate\Support\Collection
    {
       return $this->contractRepo->list($request, $guid);
    }

    public function detailContract(Request $request): \Illuminate\Support\Collection
    {
       return $this->contractRepo->detail($request);
    }

    public function getHistoryOperation($guidContract)
    {
       return $this->contractRepo->history($guidContract);
    }
}
