<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\Base\BaseController;
use App\User;
use App\UserActivations;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class UsersController extends BaseController
{
    public $id = "id";
    public $class_name = "users";
    public $model = "\App\User";

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => [
            'store',
            'login',
            'requestPasswordReset',
            'requestVerificationEmail',
            'resetPassword',
            'verifyEmail']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $defaultLimit = 100;

        $allUsers = User::limit($defaultLimit)->get();

        if ($request->has('where') && $request->has('order')) {
            return $this->sendResponse(config('imbaas_messages.wrong_query_parameters'), Response::HTTP_BAD_REQUEST);
        }

        $table = $this->class_name;
        if ($request->has('select')) {
            $query = DB::table($table)->select(DB::raw($request['select']));
        }else{
            $query = DB::table($table)->select("*");
        }

        if ($request->has('skip')) {
            $query = $query->skip($request['skip'], $defaultLimit);
        }

        if ($request->has('where')) {
            $whereObject = $request['where'];
            $whereObject = json_decode($whereObject);
            foreach ($whereObject as $key => $value) {
                $query = $query->where([
                    $key => $value
                ]);
            }
        }

        if ($request->has('limits')) {
            $query = $query->take($request['limits'], $defaultLimit);
        }

        if ($request->has('order')) {
            $orderObject = $request['order'];
            $orderObject = json_decode($orderObject);
            foreach ($orderObject as $key => $value) {
                $query = $query->orderBy($key, $value);
            }
        }

        if ($request->has('paginate')) {
            $results = $query->paginate($request['paginate']);
        }
        else {
            $results = $query->get();
        }


        return $this->sendResponse($results, Response::HTTP_OK);
    }

    /**
     * Display current logged-in user of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function me(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user) {
            return $user;
        }
        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where(['email' => $request["email"]])->exists();
        if($user) {
            return $this->sendResponse(config('imbaas_messages.email_already_in_use'), Response::HTTP_BAD_REQUEST);
        }

        $user = User::where(['username' => $request["username"]])->exists();
        if($user) {
            return $this->sendResponse(config('imbaas_messages.username_already_in_use'), Response::HTTP_BAD_REQUEST);
        }

        $validator = Validator::make($request->all(), Config::get('imbaas_api_validator_rules.user_signup_rules'));

        if($validator->fails()) {
            return $this->sendResponse(Config::get('imbaas_messages.invalid_signup_info'), Response::HTTP_BAD_REQUEST);
        }


        $user = User::create($request->all());
        $token = JWTAuth::fromUser($user);
        UserActivations::create([
            'user_id' => $user->id,
            'token' => str_random(40),
        ]);
        if ($request->has('password')) {
            $user->password = bcrypt($request['password']);
            $user->save();
        }

        $user->sendVerifyEmail();

        return $this->sendResponse(compact('user', 'token'), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user_auth = JWTAuth::parseToken()->authenticate();
        if ($user_auth) {
            $user = User::where('id', $id)->first();
            if ($user) {
                return $this->sendResponse(compact('user'), Response::HTTP_OK);
            } else {
                return $this->sendResponse(Config::get('imbaas_messages.user_not_found'), Response::HTTP_NOT_FOUND);
            }
        } else {
            return $this->sendResponse(Config::get('imbaas_messages.invalid_token'), Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($request->has('emailVerified')) {
            return $this->sendResponse(Config::get('imbaas_messages.invalid_update_data'), Response::HTTP_BAD_REQUEST);
        }

        if ($user && $user->id == $id) {
            $validator = Validator::make($request->all(), Config::get('imbaas_api_validator_rules.user_update_rules'));
            if($validator->fails()) {
                return $this->sendResponse(Config::get('imbaas_messages.invalid_update_data'), Response::HTTP_BAD_REQUEST);
            }

            if ($request->has('email') && $request["email"] != $user->email) {
                $user = User::where(['email' => $request["email"]])->exists();
                if($user) {
                    return $this->sendResponse(config('imbaas_messages.email_already_in_use'), Response::HTTP_BAD_REQUEST);
                }
            } else {
                $class = $this->model;
                $user = $class::findorFail($id);
                $user->fill($request->all())->save();
                if ($request->has('password')) {
                    $user->password = bcrypt($request['password']);
                    $user->save();
                }
                if ($request->has('should_logout_other_devices')) {
                    $token = $request['token'];
                    $invalidated = JWTAuth::invalidate($token);
                    if ($invalidated) {
                        return $this->sendResponse("{$user->name}".Config::get('imbaas_messages.user_account_updated')." And Logged out from other devices", Response::HTTP_UNAUTHORIZED);
                    } else {
                        return $this->sendResponse(Config::get('imbaas_messages.invalid_token'), Response::HTTP_UNAUTHORIZED);
                    }
                }

            }

            return $this->sendResponse("{$user->name} Account".Config::get('imbaas_messages.user_account_updated'), Response::HTTP_UNAUTHORIZED);
        }
        return $this->sendResponse(Config::get('imbaas_messages.invalid_token'), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user && $id == $user->id) {
            $user_to_delete = User::where('id', $id);
            $user_to_delete->delete();

            return $this->sendResponse(Config::get('imbaas_messages.user_deleted'), Response::HTTP_OK);
        }
        return $this->sendResponse(Config::get('imbaas_messages.invalid_action'), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Login user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($request->all(), Config::get('imbaas_api_validator_rules.user_login_rules'));

        if($validator->fails()) {
            return $this->sendResponse(Config::get('imbaas_messages.invalid_email_password'), Response::HTTP_UNAUTHORIZED);
        }

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        if (config('imbaas_settings.shouldVerifyEmail') == true) {
            if ($token) {
                $loggedUser = User::where('email', $request['email'])->first();
                if ($loggedUser) {
                    if ($loggedUser->emailVerified) {
                        // all good so return the token
                        return $this->sendResponse(compact('token'), Response::HTTP_OK);
                    } else {
                        return $this->sendResponse(Config::get('imbaas_messages.unverified_email'), Response::HTTP_UNAUTHORIZED);
                    }
                }
            }
        }
        return $this->sendResponse(compact('token'), Response::HTTP_OK);
    }

    /**
     * LogOut user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        //
        $token = $request['token'];
        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if($validator->fails()) {
            return $this->sendResponse(Config::get('imbaas_messages.invalid_token'), Response::HTTP_UNAUTHORIZED);
        }

        $invalidated = JWTAuth::invalidate($token);

        if ($invalidated) {
            return $this->sendResponse("Logged out successfully", Response::HTTP_OK);
        } else {
            return $this->sendResponse(Config::get('imbaas_messages.invalid_token'), Response::HTTP_UNAUTHORIZED);
        }

    }

    /**
     * Request Password Reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function requestPasswordReset(Request $request)
    {
        //

        $validator = Validator::make($request->only('email'), [
            'email' => 'required'
        ]);
        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }
        $response = Password::sendResetLink($request->only('email'), function (Message $message) {

        });
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->sendResponse('Reset mail sent', Response::HTTP_OK);
            case Password::INVALID_USER:
                return $this->sendResponse('User not found', Response::HTTP_NOT_ACCEPTABLE);
            default:
                return $this->sendResponse('Unauthorized info', Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * Show reset password form
     *
     * @param  \Illuminate\Http\Request  $request
     * * @param  string $token
     * @return View
     */
    public function resetPassword(Request $request, $token) {

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request['email']]
        );
    }

    /**
     * Request Verification Email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function requestVerificationEmail(Request $request)
    {
        if (config('imbaas_settings.shouldVerifyEmail') == true) {
            $user = User::where('email', $request['email'])->first();
            if ($user) {
                if ($user->emailVerified == false) {
                    $user->sendVerifyEmail();
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Verify User's Email.
     *
     * @param  \Illuminate\Http\Request  $request
     * * @param  string $token
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail(Request $request, $token) {

        $userVerification = UserActivations::where('token', $token)->first();
        if ($userVerification != null) {
            $user = User::where('id', $userVerification->user_id)->first();
            $user->verified();
            $userVerification->verified();
            return $this->sendResponse(Config::get('imbaas_messages.email_verified_successfully'), Response::HTTP_OK);
        }
        return $this->sendResponse('Unauthorized info', Response::HTTP_NOT_ACCEPTABLE);

    }
}
