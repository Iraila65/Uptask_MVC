<?php

namespace Model;

class Proyecto extends ActiveRecord {
    protected static $tabla = "proyectos";
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId'];
    
    public $id;
    public $proyecto;
    public $url;
    public $propietarioId; 

    public function __construct($args = [])
    {
        if (!isset($args['id'])) $args['id']=null;
        if (!isset($args['proyecto'])) $args['proyecto']="";
        if (!isset($args['url'])) $args['url']="";
        if (!isset($args['propietarioId'])) $args['propietarioId']="";
        
        $this->id = $args['id'];
        $this->proyecto = $args['proyecto'];
        $this->url = $args['url'];
        $this->propietarioId = $args['propietarioId'];
    }

    // Validación para la creación de una cuenta
    public function validar() {
        if(!$this->proyecto) {
            self::$alertas['error'][] = "El nombre del proyecto es obligatorio";
        }
        return self::$alertas;
    }

}