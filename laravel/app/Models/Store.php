<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'name',
        'bin',
        'city_id',
        'lat',
        'lon',
        'full_address',
        'rating',
    ];

    public function contacts()
    {
        return $this->hasMany(StoreContacts::class, 'store_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function type()
    {
        return $this->belongsTo(CompanyType::class, 'type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function media()
    {
        return $this->morphMany(MediaFiles::class, 'mediable');
    }

    public function rating()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    public function activeInvoice()
    {
        return $this->invoices()
            ->where('status', Invoice::STATUS_PAID)
            ->whereDate('expired_at', '>', Carbon::now())
            ->orderBy('id', 'desc')
            ->first();
    }
}
