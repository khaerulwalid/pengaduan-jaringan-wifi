<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLA extends Model
{
    use HasFactory;

    protected $table = 'sla';

    protected $fillable = [
        'priority',
        'response_time',
        'resolution_time',
    ];

    public function tickets()
    {
        // return $this->hasMany(Ticket::class);
    }
}
