<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model {

    protected $table = 'registry';
    protected $fillable = [
        'codigo_ies', 
        'id_period', 
        'codigo_carrera', 
        'ci_estudiante',
        'nombre_estudiante',
        'nombre_institucion',
        'tipo_institucion',
        'fecha_inicio',
        'fecha_fin',
        'campo_especifico',
        'numero_horas',
        'docente_tutor',
        'convalidacion'
    ];

    public function period(){
        return $this->hasOne('App\Period','id','id_period');
    }
}
