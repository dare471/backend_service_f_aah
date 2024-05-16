<?php

namespace App\Http\Resources\outsideService;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Services\ContractService;

class bafContractList extends JsonResource
{
    protected $contractService;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->contractService = app(ContractService::class);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sumPaid = $this->contractService->getHistoryOperation($this->guidContract);
        return [
            "guidContract" => $this->guidContract,
            "name" => $this->name,
            "trading" => $this->programContract == "Фьючерсный(Трейдинг)" ? true : false,
            "signatureStatus" => $this->signatureStatus == "Не подписан" ? false : true,
            "deliveryMethod" => $this->deliveryMethod,
            "sum" => (float)$this->sum,
            "sumPaid" => $sumPaid,
            "debt" => (float)$this->sum - $sumPaid
        ];
    }

    private function minus($sumPaid)
    {
        return $sumPaid < 0 ? 0 : $sumPaid;
    }
}
