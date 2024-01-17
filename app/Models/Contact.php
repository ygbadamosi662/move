<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Hash;
use App\Models\Enums\ContactShip;
use App\Models\Enums\ContactType;

class Contact extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['type', 'phone_number', 'name', 'ship'];

    protected $attributes = [
        'type' => ContactType::OTHER,
        'ship' => ContactShip::OTHER,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
