<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'token',
        'end_date',
        'company_id',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }
}
