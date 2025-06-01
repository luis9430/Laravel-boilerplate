<?php

namespace WPLaravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkflowHistory extends BaseModel
{
    protected $table = 'wfw_workflow_history'; // Ajusta 'wfw_'

    // Por defecto, Eloquent maneja created_at y updated_at.
    // Si tu tabla de historial solo tiene 'occurred_at' y no los otros dos,
    // y 'occurred_at' es tu principal timestamp de creación:
    const CREATED_AT = 'occurred_at'; // Le dice a Eloquent que use 'occurred_at' como 'created_at'
    const UPDATED_AT = null; // Deshabilita 'updated_at' si no existe en la tabla

    // O si prefieres manejar 'occurred_at' manualmente y no usar los timestamps de Eloquent:
    // public $timestamps = false;


    protected $fillable = [
        'workflow_instance_id',
        'transition_id',
        'from_state_id',
        'to_state_id',
        'user_id',
        'actor_details',
        'notes',
        'occurred_at', // Si no usas $timestamps = false y no redefines CREATED_AT/UPDATED_AT
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        // No incluyas 'created_at' o 'updated_at' en $casts si los has deshabilitado
        // o redefinido con las constantes CREATED_AT / UPDATED_AT.
    ];

    /**
     * Una entrada de historial pertenece a una instancia de workflow.
     */
    public function workflowInstance(): BelongsTo
    {
        return $this->belongsTo(WorkflowInstance::class);
    }

    /**
     * La transición que causó esta entrada de historial (puede ser nula).
     */
    public function transition(): BelongsTo
    {
        return $this->belongsTo(WorkflowTransition::class, 'transition_id');
    }

    /**
     * El estado desde el cual se cambió (puede ser nulo).
     */
    public function fromState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class, 'from_state_id');
    }

    /**
     * El estado al cual se cambió.
     */
    public function toState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class, 'to_state_id');
    }

    /**
     * NOTA: Para obtener el usuario de WordPress, usarías $this->user_id
     * con get_user_by('id', $this->user_id) manualmente si lo necesitas.
     */
}