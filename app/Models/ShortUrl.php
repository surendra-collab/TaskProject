<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $fillable = [
        'user_id',
        'original_url',
        'code',
        'company_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
