<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

     /**
     * The attributes that should be appended.
     *
     * @var array
     */
    protected $appends = [
        'full_name'
    ];

    /******************************************************
     * Relationships
     ******************************************************/

    /**
     * Get the notes for a user.
     */
    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

     /******************************************************
     * Attributes
     ******************************************************/

    /**
     * Get the full name of a user.
     */
    public function getFullNameAttribute()
    {
        return implode(' ', array_filter([ucfirst($this->first_name, ucfirst($this->last_name))]));
    }

}
