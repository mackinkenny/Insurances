<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    //relationship - contracts with companies
    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }

    //relationship - contracts with country
    public function country() {
        return $this->belongsTo(Country::class);
    }


    public function requests() {
        return $this->hasMany(Search::class);
    }

    public function uploader() {
        return $this->belongsTo(Company::class, 'upload_id');
    }
}
