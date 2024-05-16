<?php

namespace App\Http\Controllers\outsideService;

use App\Http\Controllers\Controller;
use App\Http\Resources\outsideService\statGovClient;
use App\Http\Services\OutSideClientService;
use Illuminate\Http\Request;

class StatGovClientController extends Controller
{

    protected  $outSideClient;

    public function  __construct(OutSideClientService $outSideClient)
    {
        $this->outSideClient = $outSideClient;
    }
    public function getClient(Request $request)
    {
        $data = $this->outSideClient->getClient($request);
        return statGovClient::collection($data)->all();
    }
    public function setClient(Request $request)
    {
        $data = $this->outSideClient->setClient($request);
        return statGovClient::collection($data)->all();
    }
}
