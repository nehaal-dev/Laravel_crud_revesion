<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected   $fillable = [
            'name',
            'gender',
            'payment',
            'country',
            'profile'
        ];

        protected $casts = [
            'payment'=>'array'
        ];

        
}