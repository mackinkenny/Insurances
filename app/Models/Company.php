<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'address',
        'country_id',
        'tax_id',
        'phone',
        'type',
        'user_id',
        'parent_id',
        'logo',
        'example',
        'tokens_count',
        'city',
        'api_key'
    ];

    //relationship - companies with trusted phones
    public function phones() {
        return $this->hasMany(Phone::class);
    }
    //relationship - agencies with company
    public function parents()
    {
        return $this->belongsToMany(self::class,'company_agency', 'company_id', 'parent_id');
    }
    //relationship - company with agencies
    public function agencies()
    {
        return $this->belongsToMany(self::class, 'company_agency', 'parent_id')->withPivot('share');
    }
    //relationship - companies with policy number masks
    public function masks() {
        return $this->hasMany(Mask::class);
    }

    //relationship - companies with contracts
    public function contracts() {
        return $this->hasMany(Contract::class, 'company_id');
    }

    //relationship - companies with tokens table
    public function tokens() {
        return $this->hasMany(Token::class);
    }

    //relationship - company with owner account
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }

    //relationship - company with employees account
    public function employees() {
        return $this->hasMany(User::class, 'company_id');
    }

    //relationship - company with country
    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function uploads() {
        return $this->hasMany(Contract::class, 'upload_id');
    }

    public function invites() {
        return $this->hasMany(Invite::class, 'company_id');
    }


    public function checkTokens() {
        $this->tokens_count = $this->tokens->sum('amount');
        $this->save();
    }

    static function getCompanyId() {
        $id = \Auth::user()->company_id ? \Auth::user()->company_id : \Auth::user()->company->id;

        return $id;
    }

}
