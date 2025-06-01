<?php

namespace WPLaravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkflowState extends BaseModel
{
    protected $table = 'wfw_workflow_states'; // Ajusta 'wfw_'

    protected $fillable = [
        'workflow_id',
        'name',
        'slug',
        'description',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Un estado pertenece a un workflow.
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    /**
     * Transiciones que originan desde este estado.
     */
    public function transitionsFrom(): HasMany
    {
        return $this->hasMany(WorkflowTransition::class, 'from_state_id');
    }

    /**
     * Transiciones que apuntan hacia este estado.
     */
    public function transitionsTo(): HasMany
    {
        return $this->hasMany(WorkflowTransition::class, 'to_state_id');
    }
}