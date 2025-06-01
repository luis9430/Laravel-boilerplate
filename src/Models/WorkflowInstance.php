<?php

namespace WPLaravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkflowInstance extends BaseModel
{
    protected $table = 'wfw_workflow_instances'; // Ajusta 'wfw_'

    protected $fillable = [
        'workflow_id',
        'entity_id',
        'entity_type',
        'current_state_id',
        'context',
        'scheduled_check_at',
    ];

    protected $casts = [
        'context' => 'array', // Si almacenas contexto como JSON
        'scheduled_check_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Una instancia pertenece a una definición de workflow.
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    /**
     * El estado actual de esta instancia.
     */
    public function currentState(): BelongsTo
    {
        return $this->belongsTo(WorkflowState::class, 'current_state_id');
    }

    /**
     * Una instancia tiene un historial de cambios.
     */
    public function history(): HasMany
    {
        return $this->hasMany(WorkflowHistory::class);
    }

    /**
     * NOTA: Obtener la entidad de WooCommerce (ej. WC_Order) asociada
     * se haría manualmente en un servicio usando $this->entity_id y $this->entity_type.
     * Ejemplo: if ($this->entity_type === 'shop_order') { $order = wc_get_order($this->entity_id); }
     */
}