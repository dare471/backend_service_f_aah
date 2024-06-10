<?php

namespace App\Services\Client;

use App\Repositories\Client\Contract\ContractRepository;

class OrderService
{
   protected $orderRepo;
   public function __construct(ContractRepository $orderRepo)
   {
        $this->orderRepo = $orderRepo;
   }
   public function getGuidOrder($orderGuid): \Illuminate\Support\Collection
   {
       return $this->orderRepo->getOrder($orderGuid);
   }
}
