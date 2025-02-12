<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets'; // Pastikan nama tabel benar

    protected $fillable = [
        'ticket_number',
        'customer_id',
        'category_id',
        'description',
        'status',
        'priority',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // // Relasi ke User (Pembuat Tiket)
    // public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    // // Relasi ke User (Updater Tiket)
    // public function updatedBy()
    // {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }
}
