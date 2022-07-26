<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class SubscriptionPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'duration' => $this->validity,
            'price' => $this->price, 
        ];
    }
}