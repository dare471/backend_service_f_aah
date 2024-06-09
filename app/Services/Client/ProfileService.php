<?php

namespace App\Services\Client;
use App\Repositories\Client\Profile\ProfileRepository;

class ProfileService
{
    protected $profileRepo;
    public function __construct(ProfileRepository $profileRepo)
    {
        $this->profileRepo = $profileRepo;
    }
    public  function getInfo($clientGuid)
    {
        return $this->profileRepo->getClient($clientGuid);
    }
}

