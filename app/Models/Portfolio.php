<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title'
    ];

    /**
     * Get the contents for the portfolio.
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Get the comments for the portfolio.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the first content for the portfolio (for preview).
     */
    public function firstContent()
    {
        return $this->hasOne(Content::class)->oldest();
    }
}