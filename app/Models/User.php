<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'discount',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctor_id');
    }

    public function notificationsReceived()
    {
        return $this->hasMany(Notification::class, 'receiver_id');
    }

    public function notificationsSent()
    {
        return $this->hasMany(Notification::class, 'sender_id');
    }

    public function doctorScans()
    {
        // Scans associated with the doctor_id
        return $this->hasMany(Scan::class, 'doctor_id');
    }

    public function labScans()
    {
        // Scans associated with the lab_id
        return $this->hasMany(Scan::class, 'lab_id');
    }

    public function externalLabScans()
    {
        // Scans associated with the external_lab_id
        return $this->hasMany(Scan::class, 'external_lab_id');
    }

    public function workPrices()
    {
        return $this->hasMany(DoctorWorkPrice::class, 'doctor_id');
    }


}
