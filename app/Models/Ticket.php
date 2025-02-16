<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets'; // Pastikan nama tabel benar

    protected $fillable = [
        'title',
        'ticket_number',
        'customer_id',
        'category_id',
        'description',
        'status',
        'priority',
        'created_by',
        'updated_by',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Customer
    // public function customer()
    // {
    //     return $this->belongsTo(User::class, 'customer_id');
    // }

    // Relasi ke tabel SLA
    public function sla()
    {
        return $this->belongsTo(Sla::class, 'sla_id');
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke User (Pembuat Tiket)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function priority()
    {
        return $this->belongsTo(SLA::class, 'sla_id');
    }
}
