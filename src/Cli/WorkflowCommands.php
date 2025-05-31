<?php
//Cli/WorkflowCommands.php
namespace WPLaravel\Cli; 

use WP_CLI;
use WP_CLI_Command;
use WPLaravel\Database\CreateWorkflowSystemTables; // Tu clase de migración

/**
 * Gestiona la base de datos del sistema de workflows.
 */
class WorkflowCommands extends WP_CLI_Command
{

    public function migrate_up($args, $assoc_args) // Cambiado a migrate:up
    {
        $migration = new CreateWorkflowSystemTables();
        try {
            $migration->up();
            WP_CLI::success('Tablas del sistema de workflows creadas/verificadas exitosamente.');
        } catch (\Exception $e) {
            WP_CLI::error('Error al crear las tablas del sistema de workflows: ' . $e->getMessage());
        }
    }

    /**
     * Elimina las tablas de la base de datos del sistema de workflows.
     *
     * ## EJEMPLOS
     *
     * wp wplaravel workflow migrate:down
     *
     * @when after_wp_load
     */
    public function migrate_down($args, $assoc_args) // Cambiado a migrate:down
    {
        // Podrías añadir una confirmación aquí para operaciones destructivas
        // WP_CLI::confirm( "Are you sure you want to drop all workflow tables?", $assoc_args );

        $migration = new CreateWorkflowSystemTables();
        try {
            $migration->down();
            WP_CLI::success('Tablas del sistema de workflows eliminadas exitosamente.');
        } catch (\Exception $e) {
            WP_CLI::error('Error al eliminar las tablas del sistema de workflows: ' . $e->getMessage());
        }
    }

    /**
     * (Opcional) Un comando para refrescar las tablas (down y luego up).
     *
     * ## EJEMPLOS
     *
     * wp wplaravel workflow migrate:refresh
     *
     * @when after_wp_load
     */
    public function migrate_refresh($args, $assoc_args)
    {
        WP_CLI::log('Eliminando tablas del sistema de workflows...');
        $this->migrate_down($args, $assoc_args);
        WP_CLI::log('Creando tablas del sistema de workflows...');
        $this->migrate_up($args, $assoc_args);
        WP_CLI::success('Tablas del sistema de workflows refrescadas exitosamente.');
    }
}