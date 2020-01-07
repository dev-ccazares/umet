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
            'numero_horas' => 'integer|min:0|max:1000',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'after_or_equal:fecha_inicio',
        ],[
            'codigo_ies.required' => 'El campo es requerido',
            'ci_estudiante.required' => 'El campo es requerido',
            'fecha_inicio.required' => 'El campo es requerido',
            'nombre_estudiante.required' => 'El campo es requerido',
            'nombre_institucion.required' => 'El campo es requerido',
            'numero_horas.min' => 'Ingrese solo números mayor a cero',            
            'numero_horas.max' => 'Ingrese solo números menores a 1000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if($request->has('convalidacion')){
            $request->numero_horas = 0; 
            $request->docente_tutor = 'Ing. William Chumi'; 
        }
        $data = $request->all();
        $data['docente_tutor'] = mb_convert_case($request->docente_tutor, MB_CASE_UPPER, "UTF-8");
        $data['nombre_institucion'] = mb_convert_case($request->nombre_institucion, MB_CASE_UPPER, "UTF-8");
        $data['nombre_estudiante'] = mb_convert_case($request->nombre_estudiante, MB_CASE_UPPER, "UTF-8");
        $save = Registry::create($data);
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
            'numero_horas' => 'integer|min:0|max:1000',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'after_or_equal:fecha_inicio',
        ],[
            'codigo_ies.required' => 'El campo es requerido',
            'ci_estudiante.required' => 'El campo es requerido',
            'fecha_inicio.required' => 'El campo es requerido',
            'nombre_estudiante.required' => 'El campo es requerido',
            'nombre_institucion.required' => 'El campo es requerido',
            'numero_horas.min' => 'Ingrese solo números mayor a cero',
            'numero_horas.max' => 'Ingrese solo números menores a 1000',
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

        if(!$request->has('papeleo')){
            $request->request->add(['papeleo' => 0]); 
        }
        
        if(!$request->has('fecha_fin')){
            $request->request->add(['fecha_fin' => null]); 
        }
        $data = $request->all();
        $data['docente_tutor'] = mb_convert_case($request->docente_tutor, MB_CASE_UPPER, "UTF-8");
        $data['nombre_institucion'] = mb_convert_case($request->nombre_institucion, MB_CASE_UPPER, "UTF-8");
        $data['nombre_estudiante'] = mb_convert_case($request->nombre_estudiante, MB_CASE_UPPER, "UTF-8");
        $update = Registry::find($id)->update($data);
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

    public function word(Request $request){

        $estudiante = Registry::find($request->id);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addImage(storage_path('app/public/logo.jpeg'),array('width' => 90, 'height' => 50, 'align' => 'left'));
        date_default_timezone_set("America/Guayaquil");
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = strftime("DM Quito, %d de %B del %Y");
        $section->addText(htmlspecialchars($fecha),[],array('alignment' => 'right'));
        $section->addText(htmlspecialchars(mb_convert_case($request->titulo, MB_CASE_UPPER, "UTF-8")),array('bold' => true),array("spaceBefore" => 0, "spaceAfter" => 0, "spacing" => 0));
        $section->addText(htmlspecialchars(mb_convert_case($request->nombre, MB_CASE_UPPER, "UTF-8")),array('bold' => true),array("spaceBefore" => 0, "spaceAfter" => 0, "spacing" => 0));
        $section->addText(htmlspecialchars(mb_convert_case($request->cargo, MB_CASE_UPPER, "UTF-8")),array('bold' => true),array("spaceBefore" => 0, "spaceAfter" => 0, "spacing" => 0));
        $section->addText(htmlspecialchars(mb_convert_case($estudiante->nombre_institucion, MB_CASE_UPPER, "UTF-8")),array('bold' => true),array("spaceBefore" => 0, "spaceAfter" => 0, "spacing" => 0));
        $section->addTextBreak(1);
        $section->addText(htmlspecialchars('Presente.-'),array('bold' => true),array("spaceBefore" => 0, "spaceAfter" => 0, "spacing" => 0));
        $section->addTextBreak(1);
        $section->addText(htmlspecialchars('El motivo de la presente es para solicitar a usted muy comedidamente la realización de prácticas 
                                            pre profesional en la empresa '.mb_convert_case($estudiante->nombre_institucion, MB_CASE_UPPER, "UTF-8").' , al/la Sr/ta. '.mb_convert_case($estudiante->nombre_estudiante, MB_CASE_UPPER, "UTF-8").' con 
                                            cédula de identidad: '.$estudiante->ci_estudiante.' , estudiante de '.mb_convert_case($request->nivel, MB_CASE_TITLE, "UTF-8").' Semestre de la Carrera de 
                                            Sistemas de Información en la Universidad Metropolitana del Ecuador (UMFT).'),[],array('align' => 'both'));
        
        $section->addText(htmlspecialchars('Cabe mencionar que dichas practicas son un requisito para la graduadón del estudiante y debe tener una duración mínima de 400 horas, en el horario que usted tenga a convenir con el estudiante.'),[],array('both' => 'Justify'));
        $section->addText(htmlspecialchars('A la espera de una respuesta favorable me despido, deseándole éxitos en sus labores diarias.'),[],array('both' => 'Justify'));
        $section->addTextBreak(1);
        $section->addText(htmlspecialchars('Atentamente.'),[],array('both' => 'Justify'));
        $section->addTextBreak(10);
        $section->addText(htmlspecialchars('Ing. William Chumi Sarmiento, Msc'),[],array("spaceBefore" => 0, "spaceAfter" => 0, "spacing" => 0));
        $section->addText(htmlspecialchars('COORDINADOR DE PRÁCTICAS PRE PROFESIONALES'),array('bold' => true),array("spaceBefore" => 0, "spaceAfter" => 0, "spacing" => 0));
        $section->addText(htmlspecialchars('CARRERA DE SISTEMAS DE INFORMACIÓN'),array('bold' => true),array("spaceBefore" => 0, "spaceAfter" => 0, "spacing" => 0));

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path($estudiante->nombre_estudiante.'.docx'));
        return response()->download(storage_path($estudiante->nombre_estudiante.'.docx'));
    }

}
