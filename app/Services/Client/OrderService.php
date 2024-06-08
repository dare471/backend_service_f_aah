<?php

namespace App\Services\Client;

use App\Repositories\Client\Order\OrderRepository;

class OrderService
{
   protected $orderRepo;
   public function __construct(OrderRepository $orderRepo)
   {
        $this->orderRepo = $orderRepo;
   }
   public function getGuidOrder($orderGuid): \Illuminate\Support\Collection
   {
       return $this->orderRepo->getOrder($orderGuid);
   }
}
