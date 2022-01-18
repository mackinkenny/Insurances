<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    //relationship - countries with company
    public function companies() {
        return $this->hasMany(Company::class);
    }

    //relationship - countries with contract
    public function contract() {
        return $this->hasOne(Contract::class);
    }
}
