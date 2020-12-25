<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Controllers\ValidateUtils\UserUtils;
    use App\Models\Usuario;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Tymon\JWTAuth\JWTAuth;

    class UserController extends Controller {
        
        /**
         * Create a new controller instance.
         *
         * @param JWTAuth $jwt
         */
        public function __construct(JWTAuth $jwt) {
            parent::__construct($jwt);
        }
        
        public function info() {
            $user = Auth::user();
            return responseOk('user data', $user);
        }
        
        public function logout() {
            Auth::logout();
            return responseOk('token invalided');
        }
        
        public function getUsers() {
            return response()->json(Usuario::all());
        }
        
        public function getUser($id) {
            return response()->json(Usuario::find($id));
        }
        
        public function deleteUser($id) {
            $user = Usuario::find($id);
            $user->delete();
            return response()->json("DELETED!!", 200);
        }
        
        public function updateUser($id, Request $request) {
            $this->validate($request, UserUtils::UPDATE_USER);
            
            $user = Usuario::find($id);
            $user->usuario = $request->usuario;
            $user->password = $request->password;
            
            $user->save();
            return response()->json($user);
        }
    }
