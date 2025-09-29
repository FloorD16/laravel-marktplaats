<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['bid', 'ad_id', 'user_id'];

    public function ad() {
        return $this->belongsTo(Ad::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
