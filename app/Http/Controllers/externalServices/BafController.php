<?php

namespace App\Http\Controllers\externalServices;

use App\Http\Controllers\Controller;
use App\Http\Resources\outsideService\bafContractDetail;
use App\Http\Resources\outsideService\bafContractList;
use App\Http\Resources\outsideService\bafClient;
use App\Http\Resources\outsideService\statGovClient;
use App\Http\Services\Contract;
use App\Http\Services\Contragent;
use Illuminate\Http\Request;

class BafController extends Controller
{
   protected $clientList;
   protected $contractService;

   public function  __construct(Contragent $clientList, Contract $contractService)
   {
       $this->clientList = $clientList;
       $this->contractService = $contractService;
   }

   public function findBin(Request $request)
   {
       $data = $this->clientList->findBin($request);
       return BafController::collection($data)->all();
   }
   public function getClient(Request $request)
   {
        $data = $this->clientList->getClient($request);
        return statGovClient::collection($data)->all();
   }
   public function setClient(Request $request)
   {
       $data = $this->clientList->setClient($request);
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
