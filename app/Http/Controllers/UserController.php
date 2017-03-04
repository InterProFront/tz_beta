<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @return array
     */
    function updateUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'alpha_dash',
                'password' => 'confirmed|min:6'
            ]
        );

        if($validator->fails()){
            return ['error' => true, 'error_message' => $validator->errors()->setFormat(':message<br>')->all()];
        }

        $user = $request->user();

        $valid = true;

        if($request->has('password'))
        {
            if($request->has('password_old')){
                $credentials = ['email' => $user->email, 'password' => $request->input('password_old')];
                $valid = Auth::validate($credentials);
            }
            else
            {
                return ['error' => true, 'error_message' => 'Для установки нового пароля необходимо ввести старый пароль!'];
            }
        }

        if($valid)
        {
            try
            {
                if($request->has('password')){
                    $user->password = bcrypt($request->input('password'));
                }

                if($request->has('fio'))
                {
                    $user->fio = $request->input('fio');
                }

                if($request->has('name'))
                {
                    $user->name = $request->input('name');
                }

                if($request->hasFile('avatar'))
                {
                    $uploadedFile = $request->file('avatar');

                    $file_path = public_path() . '/files/avatars';

                    if(!File::isDirectory($file_path))
                    {
                        File::makeDirectory($file_path);
                    }

                    $file_name = 'ava'.$user->id.'.'.$uploadedFile->guessClientExtension();

                    $uploadedFile->move(
                        $file_path,
                        $file_name
                    );

                    chmod($file_path.'/'.$file_name, 0644);

                    $user->avatar = '/files/avatars/'.$file_name;
                }

                $user->save();

                return ['error' => false, 'error_message' => ''];
            }
            catch (\Exception $exception)
            {
                return ['error' => true, 'error_message' => $exception->getMessage()];
            }
        }
        else
        {
            return ['error' => true, 'error_message'=>'Неверно введен пароль!'];
        }
    }

    public function getCurrentUser(){
        try{
            $user = Auth::user();
        }catch(\Exception $e){
            return ['error' => true,'content' => '', 'error_message' => $e->getMessage()];
        }
            return ['error' => false,'content' => $user, 'error_message' => ''];
    }

    public function getUser( Request $request ){
        try{
            $user = User::where('id', $request->input('id'))->first();
        }catch(\Exception $e){
            return ['error' => true,'content' => '', 'error_message' => $e->getMessage()];
        }
        return ['error' => false,'content' => $user, 'error_message' => ''];
    }

}
