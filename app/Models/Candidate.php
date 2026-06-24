<?php

namespace App\Models;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model {
    protected $guarded = [];
    public function votes() { return $this->hasMany(Vote::class); }
}
