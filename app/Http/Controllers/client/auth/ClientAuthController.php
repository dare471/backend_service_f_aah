<?php
namespace App\Http\Controllers\client\auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\client\send_sms\SmsMessageController;
use Illuminate\Http\Request;
use App\Models\client\auth\ClientAuth;
use App\Models\client\profile\Profile;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Carbon;

class ClientAuthController extends Controller
{
    // авторизация клиента login: email phone bin, Password остается прежним
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required_without_all:phone,bin|email',
            'phone' => 'sometimes|required_without_all:email,bin',
            'bin' => 'sometimes|required_without_all:email,phone',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        if (!$token = $this->attemptLogin($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return $this->respondWithToken($token);
    }
    
    //регистрация клиента обязательные параметры
    public function register(Request $request)
    {
        $controller = new SmsMessageController();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bin' => 'required|string|unique:clients',
            'phone' => 'required|string|max:16',
            'email' => 'required|email|min:6', // Убедитесь, что указано правильное имя таблицы
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
      
        $client = ClientAuth::create([
            'name' => $request->name,
            'bin' => $request->bin,
            'phone' => $request->phone,
            'email' => $request->email, // Проверьте, что email действительно передается сюда
            'password' => bcrypt($request->password),
        ]);

        // При регистрации создает запись профиля в таблице app_profile
        
        Profile::create([
            'client_id' => $client->id
        ]);
        $token = JWTAuth::fromUser($client);
  
        $controller->sendVerificationCode($client); // Отправка SMS кода
        return response()->json(['token' => $token]);
    }

    //Мульти логин для авторизации 
    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only('email', 'phone', 'bin', 'password');
    
        foreach (['email', 'phone', 'bin'] as $field) {
            if (!empty($credentials[$field])) {
                // Указываем использование новой гвардии client_api
                if ($token = auth('client')->attempt([$field => $credentials[$field], 'password' => $credentials['password']])) {
                    return $token;
                }
            }
        }
    
        return false;
    }
    
    // response token
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    // Выдает по токену информацию из модели Client with Profile
    public function userProfile(Request $request)
    {
        try {
            $user = auth('client')->user();
            if (!$user) {
                return response()->json(['error' => 'user_not_found'], 404);
            }

            // Выполняем запрос к модели Profile, чтобы получить профиль пользователя
            $profile = Profile::where('client_id', $user->id)->first();
            $user_pr = ClientAuth::where('bin', $user->bin)->first();
            // Возвращаем пользователя и его профиль в JSON формате
            return response()->json([
                'head' => $user_pr,
                'properties' => $profile
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'user_not_found'], 404);
        }
    }


    //Подтверждение верфикации по смс
    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string'
        ]);

        $client = ClientAuth::where('phone', $request->phone)->firstOrFail();
        if ($client->sms_verification_code === $request->code && now()->subMinutes(10)->lt($client->sms_verification_code_sent_at)) {
            $client->update([
                'sms_verification_code_sent_at' => now(), 
                'phone_verified_at' => Carbon::now()->toDateTimeString(),
                'phone_verified_status' => true,
                
            ]);
            return response()->json(['message' => 'Phone number verified']);
        }

        return response()->json(['error' => 'Invalid or expired verification code'], 401);
    }

}
