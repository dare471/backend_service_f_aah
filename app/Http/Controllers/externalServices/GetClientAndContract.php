<?php

namespace App\Http\Controllers\externalServices;

use App\Http\Controllers\Controller;
use App\Http\Resources\externalService\bafClient;
use App\Http\Resources\externalService\bafContractDetail;
use App\Http\Resources\externalService\bafContractList;
use App\Http\Resources\externalService\statGovClient;
use App\Services\Baf\ContractService;
use App\Services\ContragentService;
use Illuminate\Http\Request;

class GetClientAndContract extends Controller
{
   protected $clientList;
   protected $contractService;

   public function  __construct(ContragentService $clientList, ContractService $contractService)
   {
       $this->clientList = $clientList;
       $this->contractService = $contractService;
   }

   public function findBin(Request $request)
   {
       $data = $this->clientList->findBin($request);
       return bafClient::collection($data)->all();
   }
   public function getClient(Request $request)
   {
        $data = $this->clientList->getClient($request);
        return statGovClient::collection($data)->all();
   }

   public function listContracts(Request $request)
   {
       $data = $this->contractService->listContracts($request, $request->guidClient);
       return bafContractList::collection($data)->all();
   }

   public function detailContract(Request $request)
   {
       $data = $this->contractService->detailContract($request);
       return bafContractDetail::collection($data)->all();
   }
}
