<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'distributor_id','branch_name','address','contact_number'
    ];
}

