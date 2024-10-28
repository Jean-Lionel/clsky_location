<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reservation_id',
        'user_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    // Relations
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesseurs pour les statuts
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'refunded' => 'info'
        ][$this->status] ?? 'secondary';
    }

    public function getStatusTextAttribute()
    {
        return [
            'pending' => 'En attente',
            'completed' => 'Complété',
            'failed' => 'Échoué',
            'refunded' => 'Remboursé'
        ][$this->status] ?? $this->status;
    }
}