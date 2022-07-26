<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Order\CreateOrderOfferRequest;
use Illuminate\Http\Request;
use App\Services\v1\OrderService;

class OrderOfferController extends ApiController
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function create($id, CreateOrderOfferRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->orderService->createOffer($this->authUser(), $data, $id));
    }

    public function orderOffers($id)
    {
        return $this->result($this->orderService->getOffers($id));
    }

    public function info($id, $offerId)
    {
        return $this->result($this->orderService->infoOffer($id, $offerId));
    }

    public function accept($id, $offerId)
    {
        return $this->result($this->orderService->accept($id, $offerId));
    }
}
