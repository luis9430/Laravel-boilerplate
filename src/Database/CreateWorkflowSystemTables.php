<?php

namespace WPLaravel\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkflowSystemTables
{
    protected string $pluginTablePrefix = 'wfw_'; // Ejemplo: wfw_ (Workflow) - ¡CAMBIA ESTO A TU PREFIJO!

    public function up()
    {
        $workflowsTable = $this->pluginTablePrefix . 'workflows';
        $statesTable = $this->pluginTablePrefix . 'workflow_states';
        $transitionsTable = $this->pluginTablePrefix . 'workflow_transitions';
        $instancesTable = $this->pluginTablePrefix . 'workflow_instances';
        $historyTable = $this->pluginTablePrefix . 'workflow_history';

        // --- 1. Tabla: Workflows (myplugin_workflows) ---
        // Esta tabla no tiene FKs a otras tablas de este conjunto en su definición inicial básica.
        // La FK initial_state_id se omitirá por ahora para evitar dependencia circular en la creación.
        if (!Capsule::schema()->hasTable($workflowsTable)) {
            Capsule::schema()->create($workflowsTable, function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('entity_type', 100);
                $table->unsignedBigInteger('initial_state_id')->nullable()->comment('FK a workflow_states.id - añadir restricción manualmente si se desea después de crear states');
                $table->boolean('is_active')->default(true);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            });
        }

        // --- 2. Tabla: Workflow States (myplugin_workflow_states) ---
        // Depende de: myplugin_workflows
        if (!Capsule::schema()->hasTable($statesTable)) {
            Capsule::schema()->create($statesTable, function (Blueprint $table) use ($workflowsTable) {
                $table->id();
                $table->unsignedBigInteger('workflow_id');
                $table->string('name');
                $table->string('slug');
                $table->text('description')->nullable();
                $table->string('type', 50)->default('normal'); // ej: initial, normal, final
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->foreign('workflow_id')->references('id')->on($workflowsTable)->onDelete('cascade');
                $table->unique(['workflow_id', 'slug']);
            });
        }

        // --- 3. Tabla: Workflow Transitions (myplugin_workflow_transitions) ---
        // Depende de: myplugin_workflows, myplugin_workflow_states
        if (!Capsule::schema()->hasTable($transitionsTable)) {
            Capsule::schema()->create($transitionsTable, function (Blueprint $table) use ($workflowsTable, $statesTable) {
                $table->id();
                $table->unsignedBigInteger('workflow_id');
                $table->string('name');
                $table->unsignedBigInteger('from_state_id');
                $table->unsignedBigInteger('to_state_id');
                $table->string('event_trigger')->nullable();
                $table->text('conditions')->nullable(); // JSON o texto
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->foreign('workflow_id')->references('id')->on($workflowsTable)->onDelete('cascade');
                $table->foreign('from_state_id')->references('id')->on($statesTable)->onDelete('cascade');
                $table->foreign('to_state_id')->references('id')->on($statesTable)->onDelete('cascade');
            });
        }

        // --- 4. Tabla: Workflow Instances (myplugin_workflow_instances) ---
        // Depende de: myplugin_workflows, myplugin_workflow_states
        if (!Capsule::schema()->hasTable($instancesTable)) {
            Capsule::schema()->create($instancesTable, function (Blueprint $table) use ($workflowsTable, $statesTable) {
                $table->id();
                $table->unsignedBigInteger('workflow_id');
                $table->unsignedBigInteger('entity_id');
                $table->string('entity_type', 100);
                $table->unsignedBigInteger('current_state_id');
                $table->json('context')->nullable();
                $table->dateTime('scheduled_check_at')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->foreign('workflow_id')->references('id')->on($workflowsTable)->onDelete('cascade');
                $table->foreign('current_state_id')->references('id')->on($statesTable)->onDelete('cascade');
                $table->index(['entity_id', 'entity_type'], 'idx_entity'); // Nombre explícito para el índice
                $table->index('current_state_id');
            });
        }

        // --- 5. Tabla: Workflow History (myplugin_workflow_history) ---
        // Depende de: myplugin_workflow_instances, myplugin_workflow_transitions, myplugin_workflow_states
        if (!Capsule::schema()->hasTable($historyTable)) {
            Capsule::schema()->create($historyTable, function (Blueprint $table) use ($instancesTable, $transitionsTable, $statesTable) {
                $table->id();
                $table->unsignedBigInteger('workflow_instance_id');
                $table->unsignedBigInteger('transition_id')->nullable();
                $table->unsignedBigInteger('from_state_id')->nullable();
                $table->unsignedBigInteger('to_state_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('actor_details')->nullable();
                $table->text('notes')->nullable();
                $table->timestamp('occurred_at')->useCurrent();
                $table->foreign('workflow_instance_id')->references('id')->on($instancesTable)->onDelete('cascade');
                $table->foreign('transition_id')->references('id')->on($transitionsTable)->onDelete('set null');
                $table->foreign('from_state_id')->references('id')->on($statesTable)->onDelete('set null');
                $table->foreign('to_state_id')->references('id')->on($statesTable)->onDelete('cascade'); // O 'set null' si el estado puede ser borrado pero quieres mantener el historial
            });
        }
    }

    public function down()
    {
        // El orden de eliminación es inverso al de creación.
        Capsule::schema()->dropIfExists($this->pluginTablePrefix . 'workflow_history');
        Capsule::schema()->dropIfExists($this->pluginTablePrefix . 'workflow_instances');
        Capsule::schema()->dropIfExists($this->pluginTablePrefix . 'workflow_transitions');
        Capsule::schema()->dropIfExists($this->pluginTablePrefix . 'workflow_states');
        Capsule::schema()->dropIfExists($this->pluginTablePrefix . 'workflows');
    }
}