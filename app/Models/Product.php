<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'description',

    ];

    public function images(){
        return $this->morphToMany(Images::class, 'imageable');

    }

    public function  user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
