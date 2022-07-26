<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class StorePresenter extends BasePresenter
{
    public function detail()
    {
        return [
            'type' => !is_null($this->type) ? [
                'id' =>  $this->type->id,
                'name' => $this->type->name,
            ] : null,
            'name' => $this->name,
            'bin' => $this->bin,
            "city" => !is_null($this->city) ? [
                'id' => $this->city->id,
                'name' => $this->city->name,
            ] : null,
            'lat' => (double)$this->lat,
            'lon' => (double)$this->lon,
            'full_address' => $this->full_address,
            'photo_url' => $this->photo_url,
            'contacts' => $this->presentCollections($this->contacts, StoreContactsPresenter::class, 'info'),
            'prices' => $this->presentCollections($this->media, MediaFilePresenter::class, 'list'),
        ];
    }

    public function list()
    {
        return [
            'type' => $this->type->name,
            'rating' => $this->rating,
            'full_address' => $this->full_address,
            'photo_url' => $this->photo_url,
        ];
    }
}