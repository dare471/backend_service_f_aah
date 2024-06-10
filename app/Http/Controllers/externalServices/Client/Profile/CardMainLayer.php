<?php

namespace App\Http\Controllers\externalServices\Client\Profile;
use App\Http\Controllers\Controller;

class CardMainLayer extends Controller
{
   protected $cardClient;
   public function __construct($cardClient)
   {
       $this->cardClient = $cardClient;
   }
   public function getInfoCard($clientGuid)
   {
       return $this->cardClient->getInfo($clientGuid);
   }
}
