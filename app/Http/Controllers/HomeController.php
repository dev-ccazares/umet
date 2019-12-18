<?php

namespace App\Http\Controllers;

use App\Helpers\Format;
use Illuminate\Http\Request;
use App\Registry;
use App\Period;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Format $format)
    { 
        $this->format =  $format;
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {
        $query = Registry::select('*');
        $data['periodSelected'] = $request->has('period') ? $request->get('period') : null;
        if($request->has('period') && $request->get('period') != '' ){
            $query = $query->where('id_period',$data['periodSelected']);
        }
        if($request->has('search') && $request->get('search') != ''){
            $data['search'] = $request->has('search') ? $request->get('search') : null;
            $search = $data['search'];
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

        $data['registry'] = $query->paginate(15);
        $data['search'] = $request->has('search') ? $request->get('search') : null;
        $data['period'] = Period::all();
        return view('home',$data);
    }

    public function create (){
        $data['url'] = route('saveRegistry');
        $data['title'] = "Nuevo registro";
        return view('modalRegistry',$data);
    }

    public function save (Request $request) {
        $validator = \Validator::make($request->all(), [
            'codigo_ies' => 'required',
            'ci_estudiante' => 'required|digits:10',
        ],[
            'codigo_ies.required' => 'El campo es requerido',
            'ci_estudiante.required' => 'El campo es requerido',
            'ci_estudiante.digits' => 'El campo no debe tener 10 dígitos',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
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
            'ci_estudiante' => 'required|digits:10',
        ],[
            'codigo_ies.required' => 'El campo es requerido',
            'ci_estudiante.required' => 'El campo es requerido',
            'ci_estudiante.digits' => 'El campo no debe tener 10 dígitos',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $update = Registry::find($id)->update($request->all());
        if(!$update){
            return response($this->format->update_err(), 409);
        }
        toastr()->success('Registro Editado!');
        return response($this->format->update_ok(null), 200);
    }

    public function delete ($id) {
        $delete = Registry::find($id)->delete();
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
