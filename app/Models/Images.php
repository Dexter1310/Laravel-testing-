<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'path',
        'imageable_type',
        'imageable_id'

    ];

    public function imageable()
    {
        return $this->morphTo();

    }

}
