<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Controllers\ValidateUtils\UserUtils;
    use App\Models\Usuario;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Tymon\JWTAuth\JWTAuth;

    class LoginController extends Controller {
        
        /**
         * Create a new controller instance.
         *
         * @param JWTAuth $jwt
         */
        public function __construct(JWTAuth $jwt) {
            parent::__construct($jwt, ['login', 'insertUser']);
        }
        
        public function login(Request $request) {
            $this->validate($request, [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ]);
            
            if (!$token = $this->jwt->claims(['email' => $request->email, 'token-data' => true])->attempt($request->only('email', 'password'))) {
                return response()->json(['ERROR'], 404);
            } else {
                return response()->json(compact('token'));
            }
        }
        
        public function insertUser(Request $request) {
            $this->validate($request, UserUtils::NEW_USER);
            
            $user = new Usuario();
            $user->email = $request->email;
            $user->usuario = $request->usuario;
            $user->password = Hash::make($request->password);
            $user->verificado = false;
            
            $user->save();
            return response()->json($user);
        }
    }
