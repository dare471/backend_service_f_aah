<?php

namespace App\Repositories\Client\Order;

use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function getOrder($orderGuid): \Illuminate\Support\Collection
    {
        $q = DB::connection('L1')
            ->table('SHIPPING_STATUS_OF_GOODS')
            ->select('period', 'synonym_order',
                'type_order', 'number_order',
                DB::raw('CONVERT(VARCHAR(MAX), order_guid, 1) as order_guid'), // Convert binary to VARCHAR
                'name','state','date_events',
                DB::raw('CONVERT(INTEGER,count, 1) as count'), 'processing_rate',
                'synonym_shipment_order', 'type_shipment_order',
                'shipment_order')
            ->where( 'order_guid',  $orderGuid) // Compare with decoded GUID
            ->get();

        return $q;
    }
}
