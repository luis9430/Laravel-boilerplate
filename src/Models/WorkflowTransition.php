<?php

namespace WPLaravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkflowTransition extends BaseModel
{
    protected $table = 'wfw_workflow_transitions'; // Ajusta 'wfw_'

    protected $fillable = [
        'workflow_id',
        'name',
        'from_state_id',
        'to_state_id',
        'event_trigger',
        'conditions',
    ];

    protected $casts = [
        'conditions' => 'array', // Si almacenas condiciones como JSON
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Una transición pertenece a un workflow.
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    /**
     * Estado desde el cual parte la transición.
     */
    public function fromState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class, 'from_state_id');
    }

    /**
     * Estado al cual llega la transición.
     */
    public function toState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class, 'to_state_id');
    }
}