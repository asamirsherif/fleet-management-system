<?php

namespace App\Services\Auth;

use App\Exceptions\CustomException;
use Illuminate\Http\Response;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Location\Country;
use App\Models\Polymorphic\Status;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use App\Mail\PasswordReset;
use Exception;

class AuthService
{
    public function authenticateUserByRequest($request)
    {
        $credentials = $request->only(['username', 'email', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            unset($credentials['username']);
            $credentials['email'] = $request->email;
            if (!$token = Auth::attempt($credentials)) {
                throw new CustomException(trans('auth.failed'), Response::HTTP_BAD_REQUEST);
            }
        }
        $token = auth()->user()->createToken(config('app.name'))->accessToken;
        return $token;
    }

    public function storeUserBasic($request)
    {
        DB::beginTransaction();

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username ?? $request->first_name . $request->last_name . rand(10, 100),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ]);

        Status::firstOrCreate([
            'object_type' => User::class,
            'object_id' => $user->id,
            'status' => Status::AWAIT_ACTIVATION,
            'content' => [
                'history' => [
                    [
                        'status' => Status::AWAIT_ACTIVATION,
                        'timestamp' => Carbon::now(),
                    ],
                ],
            ],
        ]);

        DB::commit();

        return $user;
    }

    public function authWithUserId($userId)
    {
        Auth::loginUsingId($userId);
        return auth()->user()->createToken(config('app.name'))->accessToken;
    }

    public function activateUser($request)
    {
        $userStatus = auth()->user()->status;
        $userStatus->setStatus(Status::ACTIVE);
        $userStatus->save();
    }

    public function deActivateUser($request)
    {
        $userStatus = auth()->user()->status;
        $userStatus->setStatus(Status::DEACTIVATED);
        $userStatus->save();
    }

    public function getAllCountries($filters)
    {
        return Country::orderBy($filters['order_by'], $filters['order_type'])
            ->where('name', 'like', '%' . $filters['search'] . '%')
            ->orWhere('code', 'like', '%' . $filters['search'] . '%')
            ->paginate($filters['limit']);
    }

    public function checkPassword(User $user, $password)
    {
        $credentials = [
            'email' => $user->email,
            'password' => $password
        ];
        if (!auth()->attempt($credentials))
            throw new CustomException(trans('locale.wrong_password'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function forgetPassword($email)
    {
        $user = User::where('email', $email)->first();
        $token = Str::random(60) . round(microtime(true) * 1000);

        $reset = DB::table('password_reset_tokens')->where('email',$email)->first();

        if(!$reset){
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => now()
            ]);
        }

        if($reset){
            $token = $reset->token;
        }

        Mail::to($email)->send(new PasswordReset($user, $token));
    }

    public function resetPassword($token, $password)
    {
        DB::beginTransaction();

        $reset = DB::table('password_reset_tokens')->where('token', $token)->first();
        $user = User::where('email', $reset->email)->first();
        if (empty($user))
            throw new CustomException(trans('locale.invalid_token'), Response::HTTP_UNPROCESSABLE_ENTITY);
        $user->password = Hash::make($password);
        $user->save();
        DB::table('password_reset_tokens')->where('token', $token)->delete();
        DB::table('password_reset_tokens')->where('email', $reset->email)->delete();

        DB::commit();

        return $user;
    }

    public function changePassword(string $old_password, string $new_password): bool
    {
        $user = Auth::user();
        if (!Hash::check($old_password, $user->password)) {
            throw new CustomException(trans('locale.wrong_password'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $updated = $user->update([
            "password" => Hash::make($new_password)
        ]);
        return $updated;
    }

    public function updateProfile(User $user, $request)
    {
        $userMappedRequest = $request->only('name', 'first_name', 'last_name', 'email', 'password', 'phone_number');
        if ($request->has('password')) {
            //$this->checkPassword($user, $request->old_password);
            $userMappedRequest['password'] = Hash::make($request->password);
        }
        $user->update([
            "name" => $request->name ?? $user->name,
            "first_name" => $request->first_name ?? $user->first_name,
            "last_name" => $request->last_name ?? $user->last_name,
            "email" => $request->email ?? $user->email,
            "phone_number" => $request->phone_number,
        ]);


        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}
