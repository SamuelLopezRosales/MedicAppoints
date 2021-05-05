<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\User;

class AuthController extends Controller
{
     public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        // GUARDO LAS CREDENCIALES
        $credentials = request(['email', 'password']);

        // AUTH ME DEVOLVERA FALSO SI NO ESTAN LOS VALORES
        if (!Auth::attempt($credentials)) // valida si estan las credenciale
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }



    public function prueba()
    {
        return "Esto es una prueba";
    }

    public function register(Request $request){
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //Auth::guard('api')->login($user);
        Auth::guard('api')->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $access_token = $tokenResult->accessToken;
        $success = true;

        return compact('success','user','access_token');
    }

    protected function validator(array $data){
        return Validator::make($data,User::$rules);
    }

    protected function create(array $data)
    {
        return User::createPatient($data);
    }
}


