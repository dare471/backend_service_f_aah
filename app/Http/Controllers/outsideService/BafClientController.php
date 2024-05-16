<?php

namespace App\Http\Controllers\outsideService;

use App\Http\Controllers\Controller;
use App\Http\Resources\outsideService\bafContractDetail;
use App\Http\Resources\outsideService\bafContractList;
use App\Http\Resources\outsideService\bafClient;
use App\Http\Services\ContractService;
use App\Http\Services\ContragentService;
use Illuminate\Http\Request;

class BafClientController extends Controller
{
   protected $contragentService;
   protected $contractService;

   public function  __construct(ContragentService $contragentService, ContractService $contractService)
   {
       $this->contragentService = $contragentService;
       $this->contractService = $contractService;
   }

   public function findBin(Request $request)
   {
       $data = $this->contragentService->findBin($request);
       return bafClient::collection($data)->all();
   }

   public function listContracts(Request $request)
   {
       $data = $this->contractService->listContracts($request);
       return bafContractList::collection($data)->all();
   }

   public function detailContract(Request $request)
   {
       $data = $this->contractService->detailContract($request);
       return bafContractDetail::collection($data)->all();
   }
}
