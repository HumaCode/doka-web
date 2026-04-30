<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class EmailOtp extends Model
{
    protected $table = 'email_otps';
    
    protected $fillable = [
        'email',
        'otp',
        'attempts',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Check if the OTP is expired.
     */
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}
