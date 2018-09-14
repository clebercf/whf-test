<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cpf' => 'required|unique:users|cpf',
            'birth_date' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $mime = null;
        $original_filename = null;
        $filename = null;
        if (array_key_exists('photo', $data)) {
            $photo = $data['photo'];
            $filename = $photo->getFilename().'.'.$photo->getClientOriginalExtension();
            $mime = $photo->getClientMimeType();
            $original_filename = $photo->getClientOriginalName();
            Storage::disk('public')->put($filename,File::get($photo));
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf' => $data['cpf'],
                'birth_date' => $this->transform_date($data['birth_date']),
                'password' => Hash::make($data['password']),
                'mime' => $mime,
                'original_filename' => $original_filename,
                'filename' => $filename
            ]);
        } else {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf' => $data['cpf'],
                'birth_date' => $this->transform_date($data['birth_date']),
                'password' => Hash::make($data['password'])
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \App\User::find($id);
        return view('edit',compact('user','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,id',
            'birth_date' => 'required',
            'cpf' => 'required|unique:users,id|cpf',
            'password' => 'sometimes|same:password',
            'password_confirmation' => 'sometimes|same:password'  
        ]);

        $user= \App\User::find($id);
        $user->name=$request->get('name');
        $user->email=$request->get('email');
        $user->birth_date = $this->transform_date($request->get('birth_date'));
        $user->cpf=$request->get('cpf');
        $user->save();
        return redirect('users')->with('success','Usuário atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \App\User::find($id);
        $user->delete();
        return redirect('users')->with('success','Usuário apagado com sucesso');
    }

    protected function transform_date(string $d) {
        $date_to_format = date_create($d);
        $format = date_format($date_to_format,"Y-m-d");
        return strtotime($format);
    }
}
