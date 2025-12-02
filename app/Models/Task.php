<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{

    protected $fillable = [
        'code',
        'description',
        'status',
        'due_date',
        'user_id',
        'priority_id',
    ];

    // Indiquem que la columna 'creation_date' de la BDD 
    // hauria d'estar representada pel camp 'created_at' de Laravel
    const CREATED_AT = 'creation_date';

    // 1. Relació N:1 (La tasca PERTANY a un Usuari)
    public function user(): BelongsTo
    {
        // Busca a la taula 'users' utilitzant la clau forana 'user_id'
        return $this->belongsTo(User::class); 
    }

    // 2. Relació N:1 (La tasca PERTANY a una Prioritat)
    public function priority(): BelongsTo
    {
        // Busca a la taula 'priorities' utilitzant la clau forana 'priority_id'
        return $this->belongsTo(Priority::class);
    }
}