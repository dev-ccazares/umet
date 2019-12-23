<?php

namespace App\Exports;

use App\Registry;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class RegistryExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Registry::selectRaw('period.detail as "Periodo",registry.codigo_ies as "Código IES",registry.codigo_carrera as "Código Carrera",
                                    registry.ci_estudiante as "Cédula Estudiante",registry.nombre_estudiante as "Nombre Estudiante",
                                    registry.nombre_institucion as "Nombre Institución",registry.fecha_inicio as "Fecha Inicio",
                                    registry.fecha_fin as "Fecha Fin",registry.numero_horas as "Número de Horas",
                                    registry.campo_especifico as "Campo Específico",registry.docente_tutor as "Docente Tutor",
                                    (CASE registry.convalidacion WHEN 1 THEN "Si" ELSE "No" END) as "Convalidación con Trabajo"')
                                ->join('period','id_period','period.id');
        return  $this->filter($query)->get();
    }

    private function filter($query){
        if( $this->request->has('period') &&  $this->request->get('period') != '' ){
            $query = $query->where('id_period', $this->request->get('period'));
        }
        if( $this->request->has('search') &&  $this->request->get('search') != ''){
            $search =  $this->request->get('search');
            $query = $query->where(function ($q) use ( $search ) {
                $q->where('id_period','like','%'.$search.'%')
                ->orWhere('codigo_ies','like','%'.$search.'%')
                ->orWhere('codigo_carrera','like','%'.$search.'%')
                ->orWhere('ci_estudiante','like','%'.$search.'%')
                ->orWhere('nombre_estudiante','like','%'.$search.'%')
                ->orWhere('nombre_institucion','like','%'.$search.'%')
                ->orWhere('numero_horas','like','%'.$search.'%')
                ->orWhere('campo_especifico','like','%'.$search.'%')
                ->orWhere('docente_tutor','like','%'.$search.'%');
            });
        }
        return $query;
    }

    public function headings(): array
    {
        return [
           ['Periodo', 'Código IES', 'Código Carrera', 'Cédula Estudiante', 'Nombre Estudiante', 'Nombre Institución','Fecha Inicio','Fecha Fin',
            'Número de Horas','Campo Específico','Docente Tutor','Convalidación con Trabajo'],
        ];
    }
}
