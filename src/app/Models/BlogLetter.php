<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'file_path',
        'title',
        'user_id',
        'published'
    ];

    public $hidden = [
        //
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
