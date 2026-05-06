<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'inviter_id',
        'name',
        'email',
        'role',
        'company_id',
    ];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
