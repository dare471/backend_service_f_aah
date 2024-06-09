<?php

namespace App\Repositories\Client\Profile;

use App\Http\Resources\Client;
use App\Models\client\profile\ClientCard;

class ProfileRepository
{
    public function getClient($clientGuid)
    {
        $q = ClientCard::where('guid', $clientGuid)
            ->get();
        return Client::collection($q);
    }
}
