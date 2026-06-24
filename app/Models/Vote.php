<?php

namespace App\Models;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model {
    protected $guarded = [];
    public function candidate() { return $this->belongsTo(Candidate::class); }
}
