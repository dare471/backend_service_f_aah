<?php

namespace App\Http\Controllers\externalServices\Client\Order;

use App\Http\Controllers\Controller;
use App\Services\Client\OrderService;
use App\Services\Utilities\ShortURLService;

class Order extends Controller
{
    protected $orderForClient;
    protected $shortURLService;

    public function __construct(OrderService $orderForClient, ShortURLService  $shortURLService)
    {
        $this->orderForClient = $orderForClient;
        $this->shortURLService = $shortURLService;
    }
    public function getOrder($orderGuid)
    {
        $order = $this->orderForClient->getGuidOrder($orderGuid);
        return view('client.order.orderview', ['order' => $order]);
    }
    public function createShortURL($orderGuid)
    {
        $destinationUrl = route('order.client', ['orderGuid' => $orderGuid]);
        $shortURL = $this->shortURLService->createShortURL($destinationUrl);
        return response()->json(['short_url' => $shortURL]);
    }
}

