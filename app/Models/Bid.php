<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    public function ad() {
        return belongsTo(Ad::class);
    }

    public function user() {
        return belongsTo(User::class);
    }

    use HasFactory;
}
