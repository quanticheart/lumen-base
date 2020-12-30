<?php /** @noinspection PhpUndefinedMethodInspection */
    
    namespace App\Http\Controllers;
    
    use App\Helpers\HashHelper;
    use App\Http\Controllers\ValidateUtils\UserUtils;
    use App\Models\User;
    use Firebase\JWT\JWT;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\ValidationException;

    class LoginController extends Controller {
        
        public function login(Request $request) {
            try {
                $this->validate($request, UserUtils::VALIDATE_LOGIN);
                // Find the user by email
                $user = User::where('email', $request->input('email'))->first();
                
                if (!$user) {
                    // You wil probably have some sort of helpers or whatever
                    // to make sure that you have the same response format for
                    // different kind of responses. But let's return the
                    // below response for now.
                    return responseError('user name or password incorrect', 56, 404);
                }
                
                // Verify the password and generate the token
                if (Hash::check($request->input('password'), $user->password)) {
                    return responseOk('login ok', $this->jwt($user));
                }
                
                // Bad Request response
                return responseError('user name or password incorrect', 57, 401);
                
            } catch (ValidationException $e) {
                return responseExceptionError('Problema com login');
            } catch (QueryException $e) {
                return responseQueryError();
            }
        }
        
        /**
         * Create a new token.
         *
         * @param User $user
         * @return string
         */
        protected function jwt(User $user) {
            $payload = [
                'sub' => HashHelper::encrypt($user->id), // Subject of the token
                'iat' => time(), // Time when JWT was issued.
                'exp' => time() + 60 * 60 // Expiration time
            ];
            
            // As you can see we are passing `JWT_SECRET` as the second parameter that will
            // be used to decode the token in the future.
            return JWT::encode($payload, env('JWT_SECRET'));
        }
    }
