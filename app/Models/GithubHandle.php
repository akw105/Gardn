<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GithubHandle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'handle',
    ];

    /**
     * Get the user that owns the Twitter Handle.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
