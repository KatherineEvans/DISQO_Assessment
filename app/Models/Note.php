<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'note',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /******************************************************
     * Relationships
     ******************************************************/

    /**
     * Get the user for a note.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /******************************************************
     * Scope
     ******************************************************/

    /**
     * Scope notes to user.
     */
    public function scopeThisUser($query)
    {
        // If user, show notes for said user only.
        if(auth()->user()->id){
            return $query->where('user_id', auth()->user()->id);
        }

        abort(403);
    }

}
