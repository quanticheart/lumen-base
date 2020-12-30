<?php /** @noinspection PhpUndefinedFieldInspection */
    
    namespace App\Http\Controllers;
    
    use App\Http\Controllers\ValidateUtils\UserUtils;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;

    class UserController extends Controller {
        
        /**
         * Create a new controller instance.
         *
         */
        public function __construct() {
            $this->validateRoutes(['insertUser']);
        }
        
        public function session(Request $request) {
            return $this->getUser($request->auth);
        }
        
        public function logout() {
            Auth::logout();
            return responseOk('token invalided');
        }
        
        public function getUsers() {
            return response()->json(User::all());
        }
        
        public function getUser($id) {
            return response()->json(User::find($id));
        }
        
        public function deleteUser($id) {
            $user = User::find($id);
            $user->delete();
            return response()->json("DELETED!!", 200);
        }
        
        public function updateUser(Request $request) {
            $this->validate($request, UserUtils::VALIDATE_UPDATE_USER);
            
            $user = User::find($request->auth);
            $user->usuario = $request->usuario;
            $user->password = $request->password;
            
            $user->save();
            return response()->json($user);
        }
        
        public function insertUser(Request $request) {
            $this->validate($request, UserUtils::VALIDATE_NEW_USER);
            
            $user = new User();
            $user->email = $request->email;
            $user->usuario = $request->usuario;
            $user->password = Hash::make($request->password);
            $user->verificado = false;
            
            $user->save();
            return response()->json($user);
        }
    }
