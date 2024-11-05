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
        'status',
        'proof_document_path',
        'metadata'
    ];
    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'metadata' => 'array'
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

    // Accesseurs de statut
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

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    public const STATUTS = [
        'pending' => 'En attente',
        'completed' => 'Complété',
        'failed' => 'Échoué',
        'refunded' => 'Remboursé'
    ];



    /**
     * Vérifier si le paiement est un remboursement.
     */
    public function isRefund(): bool
    {
        return $this->type === 'refund';
    }

}
