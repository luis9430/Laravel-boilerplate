<?php	

namespace WPLaravel\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    protected $connection = 'default';
    
    /**
     * Obtener el nombre de la tabla con prefijo
     * Corregido para evitar doble prefijo
     */
    public function getTable()
    {
        if (strpos($this->table, $this->getConnection()->getTablePrefix()) === 0) {
            return $this->table;
        }
        
        return parent::getTable();
    }
}
