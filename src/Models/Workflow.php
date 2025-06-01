<?php

namespace WPLaravel\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workflow extends BaseModel
{
    protected $table = 'wfw_workflows'; // Ajusta 'wfw_' si usaste un prefijo diferente

    protected $fillable = [
        'name',
        'slug',
        'description',
        'entity_type',
        'initial_state_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Un workflow tiene muchos estados.
     */
    public function states(): HasMany
    {
        return $this->hasMany(WorkflowState::class);
    }

    /**
     * Un workflow tiene muchas transiciones.
     */
    public function transitions(): HasMany
    {
        return $this->hasMany(WorkflowTransition::class);
    }

    /**
     * Un workflow puede tener muchas instancias activas.
     */
    public function instances(): HasMany
    {
        return $this->hasMany(WorkflowInstance::class);
    }

    /**
     * El estado inicial de este workflow.
     * Nota: La FK a nivel de BD para initial_state_id podría haberse omitido
     * en la migración inicial para evitar dependencias circulares.
     */
    public function initialState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class, 'initial_state_id');
    }
}