<?php /** @noinspection PhpUndefinedFieldInspection */
    
    namespace App\Http\Middleware;
    
    use App\Helpers\HashHelper;
    use App\Http\Controllers\Constants\ConstantsCodes;
    use App\Http\Controllers\Constants\ConstantsMsgs;
    use Closure;
    use Exception;
    use Firebase\JWT\ExpiredException;
    use Firebase\JWT\JWT;
    use Illuminate\Http\Request;

    class Authenticate {
        /**
         * Handle an incoming request.
         *
         * @param Request $request
         * @param Closure $next
         * @return mixed
         */
        public function handle(Request $request, Closure $next) {
            $language = $request->headers->get('language', ConstantsMsgs::defaultLanguage);
            $msgs = new ConstantsMsgs($language);
            
            $token = $request->header('User-Token');
            if (!$token) {
                // Unauthorized response if token not there
                return responseTokenError($msgs->msgErrorTokenOut, ConstantsCodes::codeErrorTokenOut);
            }
            
            try {
                $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            } catch (ExpiredException $e) {
                return responseTokenError($msgs->msgErrorTokenExpired, ConstantsCodes::codeErrorTokenExpired);
            } catch (Exception $e) {
                return responseTokenError($msgs->msgErrorTokenInvalid, ConstantsCodes::codeErrorTokenInvalid);
            }
            
            // Now let's put the user in the request class so that you can grab it from there
            $request->auth = HashHelper::decrypt($credentials->sub);
            return $next($request);
        }
    }
