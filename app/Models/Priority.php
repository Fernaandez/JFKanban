<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    // Indiquem quins camps es poden assignar massivament
    protected $fillable = ['name', 'color_hex']; 

    // Relació 1:N (Una prioritat té moltes tasques)
    public function tasks(): HasMany
    {
        // El model Task té una clau forana anomenada 'priority_id'
        return $this->hasMany(Task::class); 
    }
}