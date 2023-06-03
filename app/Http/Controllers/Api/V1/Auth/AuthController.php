<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\CustomerSignupRequest;
use App\Http\Requests\V1\Auth\ActivateUserRequest;
use App\Http\Requests\V1\Auth\LogoutRequest;
use App\Http\Requests\V1\Auth\GetProfileRequest;
use App\Http\Requests\V1\Auth\UpdateProfileRequest;
use App\Http\Requests\V1\Auth\ForgetPasswordRequest;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Auth\ResetPasswordRequest;
use App\Http\Requests\V1\Auth\ChangePasswordRequest;
use App\Services\Auth\AuthService;
use App\Models\User\User\User;
use Orchid\Platform\Models\Role;
use App\Http\Resources\V1\Auth\LoginResource;
use App\Http\Resources\V1\User\ProfileResource;
use App\Models\Polymorphic\Status;

class AuthController extends ApiController {

    public function __construct(private AuthService $authService)
    {
        $this->middleware('auth:api')->only(['activateUser', 'logout', 'deActivateUser', 'getProfile', 'update', 'delete', 'changePassword']);
    }

    public function Login(LoginRequest $request)
    {
        $token = $this->authService->authenticateUserByRequest($request);
        return $this->handleResponse(new LoginResource(auth()->user(), $token));
    }

    public function signup(CustomerSignupRequest $request)
    {
        $user = $this->authService->storeUserBasic($request);
        $customerRole = Role::where('slug', 'customer')->first();
        $user->addRole($customerRole);
        $token = $this->authService->authWithUserId($user->id);
        return $this->handleResponse(new LoginResource(auth()->user(), $token));
    }

    public function activateUser(ActivateUserRequest $request)
    {
        $this->authService->activateUser($request);
        return $this->handleResponse(new ProfileResource(auth()->user()));
    }

    public function deActivateUser(ActivateUserRequest $request)
    {
        $this->authService->deActivateUser($request);
        return $this->handleResponse(new ProfileResource(auth()->user()));
    }

    public function logout(LogoutRequest $request)
    {
        //event(new UserLoggedOut(auth()->user()));
        $user = Auth::user()->token();
        $user->revoke();
        Auth::logout();
        return $this->handleResponseMessage('Successfully logged out.');
    }

    public function getProfile(GetProfileRequest $request)
    {
        return $this->handleResponse(new ProfileResource(auth()->user()));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->authService->updateProfile(auth()->user(), $request);
        return $this->handleResponseMessage('Profile has been updated successfully.');
    }

    public function delete()
    {
        $this->authService->delete(auth()->user());
        return $this->handleResponseMessage('Profile has been deleted successfully.');
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $this->authService->forgetPassword($request->email);
        return $this->handleResponseMessage('Mail has been sent successfully.');
    }

    public function resetPasswordEmail(Request $request)
    {
        return $this->handleResponse( (object) ['token' => $request->token]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = $this->authService->resetPassword($request->token, $request->password);
        $token = Auth::login($user);
        return $this->handleResponse(new LoginResource(auth()->user(), $token));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $changed = $this->authService->changePassword($request->old_password, $request->password);
        return $changed ?
            $this->handleResponseMessage("Password has been updated successfully") :  $this->handleResponseError("Something went wrong!");
    }

    public function listUserStatuses()
    {
        $statuses = collect(Status::USER_STATUSES)->mapWithKeys(function ($obj) {
            return [(int)$obj =>
            [
                'title' => Status::constToString($obj, User::class),
                'class' => Status::find($obj)->__htmlSpanClass()
            ]];
        });
        return $this->handleResponse($statuses);
    }


    public function updateToken(Request $request)
    {
        $this->validate($request, [
            "token" => ['required']
        ]);

        $updated = $this->authService->updateToken($request->token);

        return $updated ? $this->handleResponseMessage("Token updated") : $this->handleResponseError("Something went wrong");
    }

}
