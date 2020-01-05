<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index (Request $request){
        $data['users'] = User::paginate(15);
        return view('users',$data);
    }

    public function edit($id){
        $data['url'] = route('updateUser',['id' => $id]);
        $data['user'] = User::find($id);
        return view('auth.registerEdit',$data);
    }

    public function editPassword($id){
        $data['url'] = route('updatePassword',['id' => $id]);
        $data['user'] = User::find($id);
        return view('auth.password',$data);
    }

    public function updatePassword($id,Request $request){
        $this->validatorPassword($request->all())->validate();
        $user = User::find($id)->update(['password' => Hash::make($request->get('password'))]);
        if($user){
            toastr()->success('Password Reestablecido!');
        }else{
            toastr()->error('Password no pudo ser Reestablecido!');
        }
        return redirect()->route('users');
    }

    protected function validatorPassword(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function update($id,Request $request){
        $request->request->add(['id' => $id]);
        $this->validator($request->all())->validate();
        $user = User::find($id);
        if($user->email == 'admin@admin.com'){
            $request->request->remove('email');
        }
        $user = $user->update($request->all());
        if($user){
            toastr()->success('Usuario Editado!');
        }else{
            toastr()->error('Usuario no pudo ser Editado!');
        }
        return redirect()->route('users');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'. $data['id']],
        ]);
    }

    public function deleteUser (Request $request){
        $delete = User::find($request->id);
        if($delete->email != 'admin@admin.com'){
            $delete = $delete->delete();
            if(!$delete){
                toastr()->error('Usuario no pudo ser Eliminado!');
            }
            toastr()->success('Usuario Eliminado!');
        }else{
            toastr()->error('Usuario no pudo ser Eliminado!');
        }
        return redirect()->route('users');
    }
    
}
