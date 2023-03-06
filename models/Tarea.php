<?php

namespace Model;

class Tarea extends ActiveRecord {
    protected static $tabla = "tareas";
    protected static $columnasDB = ['id', 'nombre', 'estado', 'proyectoId'];
    
    public $id;
    public $nombre;
    public $estado;
    public $proyectoId; 

    public function __construct($args = [])
    {
        if (!isset($args['id'])) $args['id']=null;
        if (!isset($args['nombre'])) $args['nombre']="";
        if (!isset($args['estado'])) $args['estado']=0;
        if (!isset($args['proyectoId'])) $args['proyectoId']="";
        
        $this->id = $args['id'];
        $this->nombre = $args['nombre'];
        $this->estado = $args['estado'];
        $this->proyectoId = $args['proyectoId'];
    }

    // Validación para la creación de una cuenta
    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = "El nombre de la tarea es obligatorio";
        }
        return self::$alertas;
    }

}