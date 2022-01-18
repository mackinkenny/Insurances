<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;


    protected $fillable = [
        'policy_number',
        'ip_address',
        'company_id',
        'contract_id',
        'status',
        'encrypt_number'
    ];


    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function contracts() {
        return $this->belongsTo(Contract::class);
    }
}
