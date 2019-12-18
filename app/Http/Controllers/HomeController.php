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
        $data['registry'] = Registry::paginate(15);
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
        if($save){
            return response($this->format->insert_err(), 409);
        }
        toastr()->success('Registro Agregado!');
        return response($this->format->insert_ok(null), 200);
    }
}
