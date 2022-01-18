<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'company_id',
        'ip_address',
    ];
//relationship - tokens with companies
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
