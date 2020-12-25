<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Usuario;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Tymon\JWTAuth\JWTAuth;
    use const App\Http\Controllers\ValidateUtils\UPDATE_USER;

    class ExampleController extends Controller {
        protected $jwt;
    
        /**
         * Create a new controller instance.
         *
         * @param JWTAuth $jwt
         */
        public function __construct(JWTAuth $jwt) {
            $this->jwt = $jwt;
            $this->middleware('auth:api', []);
        }
        
        public function info() {
            $user = Auth::user();
            return response()->json($user);
        }
        
        public function logout() {
            Auth::logout();
            return response()->json(['LOGOUT']);
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
            $this->validate($request, UPDATE_USER);
            
            $user = Usuario::find($id);
            $user->usuario = $request->usuario;
            $user->password = $request->password;
            
            $user->save();
            return response()->json($user);
        }
    }
