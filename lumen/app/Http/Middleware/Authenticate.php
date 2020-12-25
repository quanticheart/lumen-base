<?php
    
    namespace App\Http\Middleware;
    
    use App\Http\Controllers\Constants\ConstantsCodes;
    use App\Http\Controllers\Constants\ConstantsMsgs;
    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use Tymon\JWTAuth\Exceptions\TokenExpiredException;
    use Tymon\JWTAuth\Exceptions\TokenInvalidException;

    class Authenticate {
        /**
         * Handle an incoming request.
         *
         * @param Request $request
         * @param Closure $next
         * @param string|null $guard
         * @return mixed
         */
        public function handle($request, Closure $next, $guard = null) {
            
            $language = $request->headers->get('language', ConstantsMsgs::defaultLanguage);
            $msgs = new  ConstantsMsgs($language);
            
            try {
                $user = Auth::payload();
            } catch (TokenExpiredException $e) {
                return responseTokenError($msgs->msgErrorTokenExpired, ConstantsCodes::codeErrorTokenExpired);
            } catch (TokenInvalidException $e) {
                return responseTokenError($msgs->msgErrorTokenInvalid, ConstantsCodes::codeErrorTokenInvalid);
            } catch (JWTException $e) {
                return responseTokenError($msgs->msgErrorTokenOut, ConstantsCodes::codeErrorTokenOut);
            }
            return $next($request);
        }
    }
