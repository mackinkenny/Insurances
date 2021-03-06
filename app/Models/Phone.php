<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'company_id',
    ];

    //relationship - trusted phones with companies
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
