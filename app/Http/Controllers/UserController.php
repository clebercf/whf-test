<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $users = \App\User::where('name','like','%' . ($searchTerm) . '%')
                            ->orWhere('email','like','%' . ($searchTerm) . '%')
                            ->orWhere('cpf','like','%' . ($searchTerm) . '%')
                            ->paginate(5);
        return view('index',compact('users','searchTerm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function transform_date(string $d) {
        $date_to_format = date_create($d);
        $format = date_format($date_to_format,"Y-m-d");
        return strtotime($format);
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
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = $photo->getFilename().'.'.$photo->getClientOriginalExtension();
            $mime = $photo->getClientMimeType();
            $original_filename = $photo->getClientOriginalName();
            Storage::disk('public')->put($filename,File::get($photo));
            $user->mime = $mime;
            $user->original_filename = $original_filename;
            $user->filename = $filename;
        }
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->birth_date = $this->transform_date($request->get('birth_date'));
        $user->cpf = $request->get('cpf');
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

    private function confirm_password(array $data)
    {        
        $messages = [
            'password.required' => 'Please enter password',
        ];

        $validator = Validator::make($data, [
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password'    
        ], $messages);

        return $validator;
    } 
}