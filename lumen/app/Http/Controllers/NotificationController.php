<?php /** @noinspection PhpUndefinedFieldInspection */
    
    namespace App\Http\Controllers;
    
    use App\Helpers\SmsHelper;
    use App\Mail\MailSender;
    use App\Models\User;
    use App\Notifications\NotificationSmsUser;
    use App\Notifications\NotificationUser;
    use App\Push\PushSender;
    use Exception;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;

    class NotificationController extends Controller {
        
        /**
         * Create a new controller instance.
         *
         */
        public function __construct() {
            $this->validateRoutes(['email', 'sms', 'sendNotificationToAllUser']);
        }
        
        /**
         * Email Code Session
         */
        /**
         * @param Request $request
         * @return JsonResponse
         */
        public function email(Request $request) {
            try {
                /* example */
//            $user = User::where('email', $request->input('email'))->first();
//            $email = $request->email;
                
                $result = MailSender::toUser($request->email);
                if (!$result) {
                    return responseError('failure send to:' . Mail::failures(), 60, 500);
                } else {
                    return responseOk('e-mail send success');
                }
            } catch (Exception $e) {
                return responseQueryError();
            }
        }
        
        /**
         * Notification Code Session
         */
        
        /**
         * @param Request $request
         * @return JsonResponse
         */
        public function user(Request $request) {
            try {
                $user = User::find($request->auth);
                $user->notify(new NotificationUser($user));
                return responseOk('Example notification for ' . $user->email . ' sended');
            } catch (QueryException $e) {
                return responseQueryError();
            }
        }
        
        /**
         * @param Request $request
         * @return JsonResponse
         */
        public function unread(Request $request) {
            try {
                $user = User::find($request->auth);
                $data = $user->unreadNotifications;
                return responseOk(count($data) . ' unread notifications for ' . $user->email, $data);
            } catch (QueryException $e) {
                return responseQueryError();
            }
        }
        
        /**
         * @param Request $request
         * @return JsonResponse
         */
        public function read(Request $request) {
            try {
                $user = User::find($request->auth);
                $data = $user->readNotifications;
                return responseOk(count($data) . ' read notifications for ' . $user->email, $data);
            } catch (QueryException $e) {
                return responseQueryError();
            }
        }
        
        /**
         * @param Request $request
         * @return JsonResponse
         */
        public function all(Request $request) {
            try {
                $user = User::find($request->auth);
                $data = $user->notifications;
                return responseOk(count($data) . ' notifications for ' . $user->email, $data);
            } catch (QueryException $e) {
                return responseQueryError();
            }
        }
        
        /**
         * @param Request $request
         * @return JsonResponse
         */
        public function readByID(Request $request) {
            try {
                $nId = $request->id;
                $user = User::find($request->auth);
                $n = $user->notifications()->find($nId);
                $n->markAsRead();
                return responseOk('notification read success');
            } catch (QueryException $e) {
                return responseQueryError();
            }
        }
        
        /**
         * Sms Code Session
         * @param Request $request
         * @return JsonResponse
         */
        public function userSms(Request $request) {
            try {
                $user = User::find($request->auth);
                $user->notify(new NotificationSmsUser($user));
                return responseOk('send sms from user success');
            } catch (QueryException $e) {
                return responseQueryError();
            }
        }
        
        /**
         * @param Request $request
         * @return JsonResponse
         */
        public function sms(Request $request) {
            try {
                $rawCell = $request->cell;
                SmsHelper::send($rawCell, 'Send Sms from nexmo');
                return responseOk('send sms success');
            } catch (QueryException $e) {
                return responseQueryError();
            }
        }
        
        public function saveToken(Request $request) {
            $user = User::find($request->auth);
            $user->device_token = $request->token;
            $user->save();
            return responseOk('token saved successfully.');
        }
        
        public function sendNotificationToAllUser(Request $request) {
            $firebaseToken = User::pushTokenList();
            if (count($firebaseToken) > 0) {
                PushSender::allUsers($firebaseToken);
                return responseOk('send ok');
            } else {
                return responseOk('zero registrations in database');
            }
        }
        
        public function sendNotificationToUser(Request $request) {
            $user = User::find($request->auth);
            $token = $user->device_token;
            if ($token !== null) {
                PushSender::toUser($token);
                return responseOk('send ok');
            } else {
                return responseOk('registrations token no exists in database');
            }
        }
    }
