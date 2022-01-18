<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mask extends Model
{
    use HasFactory;
    protected $fillable = [
        'mask',
        'company_id',
    ];
    //relationship - policy number mask with companies
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
