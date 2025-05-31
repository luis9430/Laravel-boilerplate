<?php
namespace WPLaravel\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreatePluginTables
{
    /**
     * El nombre base de la tabla que usará el plugin.
     * Capsule antepondrá automáticamente el prefijo de WordPress configurado.
     */
    protected $tableName = 'wp_laravel_examples';

    /**
     * Ejecuta las "migraciones" de la base de datos.
     * Crea la tabla si no existe.
     */
    public function up()
    {
        // Verifica si la tabla ya existe (Capsule maneja el prefijo)
        if (!Capsule::schema()->hasTable($this->tableName)) {
            Capsule::schema()->create($this->tableName, function (Blueprint $table) {
                $table->id(); // Crea una columna 'id' BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
                $table->string('title'); // VARCHAR(255) NOT NULL por defecto
                $table->longText('content')->nullable();
                $table->string('status', 50)->default('active');
                $table->longText('meta_data')->nullable();
                $table->timestamps(); 
                $table->index('status'); // Crea un índice en la columna 'status'
            });
        }
    }

    /**
     * Revierte las "migraciones" de la base de datos.
     * Elimina la tabla.
     */
    public function down()
    {
        Capsule::schema()->dropIfExists($this->tableName);
    }
}