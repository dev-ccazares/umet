<?php

namespace App\Http\Controllers;

use App\Helpers\Format;
use Illuminate\Http\Request;
use App\Registry;
use App\Period;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistryExport;
class HomeController extends Controller {
 
    public function __construct(Format $format) { 
        $this->format =  $format;
        $this->middleware('auth');  
    }

    public function index(Request $request) {
        $data['periodSelected'] = $request->has('period') ? $request->get('period') : null;
        $query = Registry::select('*');
        if($request->has('order')){
            if($request->order == 'desc'){
                $data['order_list'] = 'asc'; 
            }else {
                $data['order_list'] = 'desc'; 
            }  
        }else {
            $data['order_list'] = 'desc';
        }
        if($request->has('sort')){
            $by = $request->sort;
        }else {
            $by = 'id';
        }

        $data['registry'] = $this->filter($query,$request)->orderBy($by,$data['order_list'])->paginate(15);
        $data['search'] = $request->has('search') ? $request->get('search') : null;
        $data['search'] = $request->has('search') ? $request->get('search') : null;
        $data['period'] = Period::orderBy('detail')->get();
        return view('home',$data);
    }

    private function filter($query, Request $request){
        if($request->has('period') && $request->get('period') != '' ){
            $query = $query->where('id_period',$request->get('period'));
        }
        if($request->has('search') && $request->get('search') != ''){
            $search = $request->get('search');
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
        if($request->has('final') && $request->get('final') != ''  ){
            $final = $request->get('final');
            if($request->get('final') == 'S'){
                $query = $query->where(function ($q) use ( $final ) {
                    $q->where('fecha_fin',null)
                    ->orWhere('fecha_fin','');
                });
            }else{
                $query = $query->where('fecha_fin','<>',null)->where('fecha_fin','<>','');
                if($request->get('final') == 'N'){
                    $query = $query->where('convalidacion',0);
                }else{
                    $query = $query->where('convalidacion',1);
                }
            }
        }

        return $query;
    }

    public function export(Request $request){
        return Excel::download( new RegistryExport($request), 'Reporte '.date('Y-m-d').'.xlsx');
    }

    public function create (){
        $data['url'] = route('saveRegistry');
        $data['title'] = "Nuevo registro";
        return view('modalRegistry',$data);
    }

    public function save (Request $request) {
        $validator = \Validator::make($request->all(), [
            'codigo_ies' => 'required',
            'nombre_estudiante' => 'required',
            'nombre_institucion' => 'required',
            'ci_estudiante' => 'required|digits:10',
            'numero_horas' => 'integer|min:0|max:99',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'after_or_equal:fecha_inicio',
        ],[
            'codigo_ies.required' => 'El campo es requerido',
            'ci_estudiante.required' => 'El campo es requerido',
            'fecha_inicio.required' => 'El campo es requerido',
            'nombre_estudiante.required' => 'El campo es requerido',
            'nombre_institucion.required' => 'El campo es requerido',
            'numero_horas.min' => 'Ingrese solo números mayor a cero',            
            'numero_horas.max' => 'Ingrese solo números menores a 99',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if($request->has('convalidacion')){
            $request->numero_horas = 0; 
            $request->docente_tutor = 'Ing. William Chumi'; 
        }
        $save = Registry::create($request->all());
        if(!$save){
            return response($this->format->insert_err(), 409);
        }
        toastr()->success('Registro Agregado!');
        return response($this->format->insert_ok(null), 200);
    }

    public function edit ($id){
        $data['url'] = route('updateRegistry',['id' => $id]);
        $data['title'] = "Editar registro";
        $data['tmp'] = Registry::find($id);
        return view('modalRegistry',$data);
    }

    public function update ($id,Request $request) {
        $validator = \Validator::make($request->all(), [
            'codigo_ies' => 'required',
            'nombre_estudiante' => 'required',
            'nombre_institucion' => 'required',
            'ci_estudiante' => 'required|digits:10',
            'numero_horas' => 'integer|min:0|max:99',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'after_or_equal:fecha_inicio',
        ],[
            'codigo_ies.required' => 'El campo es requerido',
            'ci_estudiante.required' => 'El campo es requerido',
            'fecha_inicio.required' => 'El campo es requerido',
            'nombre_estudiante.required' => 'El campo es requerido',
            'nombre_institucion.required' => 'El campo es requerido',
            'numero_horas.min' => 'Ingrese solo números mayor a cero',
            'numero_horas.max' => 'Ingrese solo números menores a 99',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if(!$request->has('convalidacion')){
            $request->request->add(['convalidacion' => 0]); 
        }else{
            $request->numero_horas = 0; 
            $request->docente_tutor = 'Ing. William Chumi'; 
        }

        if(!$request->has('fecha_fin')){
            $request->request->add(['fecha_fin' => null]); 
        }
        $update = Registry::find($id)->update($request->all());
        if(!$update){
            return response($this->format->update_err(), 409);
        }
        toastr()->success('Registro Editado!');
        return response($this->format->update_ok(null), 200);
    }

    public function delete (Request $request) {
        $delete = Registry::find($request->id)->delete();
        if(!$delete){
            toastr()->error('Registro no pudo ser Eliminado!');
        }
        toastr()->success('Registro Eliminado!');
        return redirect()->route('home');
    }

    public function savePeriod (Request $request) {
        $validator = \Validator::make($request->all(), [
            'detail' => 'required',
        ],[
            'detail.required' => 'El campo es requerido',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $save = Period::create($request->all());
        if(!$save){
            return response($this->format->insert_err(), 409);
        }
        toastr()->success('Periodo Agregado!');
        return response($this->format->insert_ok(null), 200);
    }

    public function editPeriod (Request $request) {
        $validator = \Validator::make($request->all(), [
            'detail' => 'required',
            'id' => 'required',
        ],[
            'detail.required' => 'El campo es requerido',
            'id.required' => 'El campo es requerido',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $update = Period::find($request->id)->update($request->all());
        if(!$update){
            return response($this->format->update_err(), 409);
        }
        toastr()->success('Periodo Editado!');
        return response($this->format->update_ok(null), 200);
    }

    public function deletePeriod (Request $request) {
        $delete = Period::find($request->id)->delete();
        if(!$delete){
            toastr()->error('Periodo no pudo ser Eliminado!');
        }
        toastr()->success('Periodo Eliminado!');
        return redirect()->route('home');
    }

}
