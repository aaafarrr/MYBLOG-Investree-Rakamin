<?php

namespace App\Models;

use App\Models\User;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'categories';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'users_id'];
    // public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function articles() {
        return $this->hasMany(Articles::class);
    }
}
