<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id'];
    
    public function user(): BelongsTo // 리턴타입?
    {
        return $this->belongsTo(User::class);
    }
}
