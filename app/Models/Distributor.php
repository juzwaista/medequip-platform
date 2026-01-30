<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'contact_number',
        'email',
        'is_verified',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

}
