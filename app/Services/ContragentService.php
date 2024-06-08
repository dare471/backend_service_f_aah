<?php

namespace App\Services;

use App\Repositories\Baf\ContragentRepository;
use Illuminate\Http\Request;
class  ContragentService
{
    protected $contragentRepo;
    public function __construct(ContragentRepository $contragentRepo)
    {
        $this->contragentRepo = $contragentRepo;
    }
    public function findBin(Request $request): \Illuminate\Support\Collection
    {
        return $this->contragentRepo->search($request);
    }
    public function getClient(Request  $request): \Illuminate\Support\Collection
    {
       return $this->contragentRepo->getClientBin($request);
    }
}
