<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = ['title', 'content', 'image', 'users_id', 'categories_id'];

    public function categories() {
        return $this->belongsTo(Categories::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
