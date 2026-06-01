<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'imdb_id', 'title', 'year', 'poster', 'type'])]
class Favorite extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
