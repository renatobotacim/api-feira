<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController {

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user['usuario_id'], // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60 * 60000, // Expiration time
            'aud' => 'app-feira-apy',
            'user' => $user
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        //return JWT::encode($payload, env('JWT_SECRET'));

        $token = JWT::encode($payload, env('JWT_SECRET'));
//        return ['HTTP_Authorization' => "Bearer {$token}"];
        return $token;
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function authenticate(User $user) {
        
        $this->validate($this->request, [
            'usuario_email' => 'required|email',
            'usuario_senha' => 'required'
        ]);
        
        // Find the user by email
        $user = User::where('usuario_email', $this->request->input('usuario_email'))->first();
        
        if (!$user) {
                         
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the 
            // below respose for now.
            return response()->json([
                        'error' => 'OPSSS! O email informado não foi encontrado em nossa base de dados. Verifique seus dados e tente novamente.'
                            ], 400);
        }

        // Verify the password and generate the token
        if (Hash::check($this->request->input('usuario_senha'), $user['usuario_senha'])) {
            return response()->json([
                        'token' => $this->jwt($user)
                            ], 200);
        }

        // Bad Request response
        return response()->json([
                    'error' => 'OPSSS! Senha incorreta. Verifique seus dados e tente novamente'
                        ], 400);
    }

}
