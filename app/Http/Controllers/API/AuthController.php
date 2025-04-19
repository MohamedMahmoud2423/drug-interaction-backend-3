<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AccessToken;
use App\Models\SessionResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;
use Twilio\Rest\Client;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use Response;

    public function index(){
        return $this->ResponseAPI(['user' => Auth()->user()], 200, "User Details");
    }

    public function update(Request $request){
        $user = Auth()->user() ?? null;
        if (empty($user)){
            return $this->ResponseAPI("error", 404, "User not found");
        }

        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'numeric', "unique:profiles,phone_number,$user->id"],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return $this->ResponseAPI("error", 401, $validator->errors()->first());
        }

        if (isset($request->new_password)) {
            $passwordRules = [
                'new_password' => ['required', 'string', 'min:5'],
            ];
            $validator = Validator::make($request->all(), $passwordRules);
            if ($validator->fails()){
                return $this->ResponseAPI("error", 401, $validator->errors()->first());
            }
            $user->password = Hash::make($request->new_password);
        }

        $profile = $user->profile;
        if (!$profile) {
            $user->profile()->create([
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
            ]);
        } else {
            $profile->update([
                'full_name' => $request->full_name ?? $profile->full_name,
                'phone_number' => $request->phone_number ?? $profile->phone_number,
            ]);
        }

        $user->save();

        return $this->ResponseAPI(['user' => $user , 'profile' => $user->profile] , 200, "Profile has edited successfully");
    }


    public function register(Request $request){
        $rules = [
            'name' => "required|string|max:255",
            'email' => "required|unique:users,email",
            'password' => "required"
        ];
        $validator = Validator::make($request->all(), $rules);
        if (count($validator->errors()) > 0){
            return $this->ResponseAPI("error", 401, $validator->errors()->first());
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $token = $user->createToken($user->name); // create token
        $plain_token = explode('|', $token->plainTextToken)[1]; // get plain text token
        AccessToken::where('tokenable_id', $user->id)->where('id', '!=', $user->get_tokens->last()->id)->delete(); // delete old tokens
        foreach ($user->get_tokens as $sol_token){
            if ($plain_token == $sol_token->token) {
                return $this->ResponseAPI($token, 200, "User has logged successfully");
            }
        }
        return $this->ResponseAPI($token, 200, "User has logged successfully");
    }
    public function login(Request $request){
        $rules = [
            'email' => "required|exists:users,email",
            'password' => "required"
        ];
        $validator = Validator::make($request->all(), $rules);
        if (count($validator->errors()) > 0){
            return $this->ResponseAPI("error", 401, $validator->errors()->first());
        }
        $credentials = $request->only(['email', 'password']);
        $token = Auth()->attempt($credentials);
        if ($token){
            $user = User::find(User::where('email', $request->email)->first()->id);
            $token = $user->createToken($user->name); // create token
            $plain_token = explode('|', $token->plainTextToken)[1]; // get plain text token
            AccessToken::where('tokenable_id', $user->id)->where('id', '!=', $user->get_tokens->last()->id)->delete(); // delete old tokens

            foreach ($user->get_tokens as $sol_token){
                if ($plain_token == $sol_token->token) {
                    return $this->ResponseAPI($token, 200, "User has logged successfully");
                }
            }
            return $this->ResponseAPI($token, 200, "User has logged successfully");
        }else{
            return $this->ResponseAPI("error", 401, 'wrong credentials');
        }
    }

    public function ResetPassword($token, Request $request)
    {
        $get_token = SessionResetPassword::where('token', $token)->first();
        if (!$get_token){
            return $this->ResponseAPI('error', 401, "Invalid token");
        }else{
            if($get_token->expire_date < Carbon::now()){
                return $this->ResponseAPI('error', 401, "Expired token");
            }else{
                $rules = [
                    'password' => "required|min:6|confirmed",
                ];
                $validator = Validator::make($request->all(), $rules);
                if (count($validator->errors()) > 0){
                    return $this->ResponseAPI("error", 401, $validator->errors()->first());
                }
                $user = User::find($get_token->user_id ?? 0);
                if ($user){
                    $user->password = Hash::make($request->password);
                    $user->save();
                    return $this->ResponseAPI('success', 200, "User password has reset successfully");
                }else{
                    return $this->ResponseAPI("error", 401, "User not found");
                }
            }
        }
    }
}
