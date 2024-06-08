<?php

namespace App\Http\Controllers\externalServices;

use App\Http\Controllers\Controller;
use App\Services\LocationAddress;
use Illuminate\Http\Request;

class Gis extends Controller
{
    protected $locationAddressPoint;
    public function __construct(LocationAddress $locationAddressPoint)
    {
        $this->locationAddressPoint=$locationAddressPoint;
    }
    public function searchPointAddress(Request $request)
    {
        return $this->locationAddressPoint->searchPoint($request);
    }
}
