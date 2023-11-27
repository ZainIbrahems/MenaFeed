<?php

namespace TCG\Voyager\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;
use TCG\Voyager\Facades\Voyager;

class VoyagerAuthController extends Controller
{
    use AuthenticatesUsers;

    public function login()
    {
        if ($this->guard()->user()) {
            return redirect()->route('voyager.dashboard');
        }

        return Voyager::view('voyager::login');
    }

    public function forget_password()
    {
        if ($this->guard()->user()) {
            return redirect()->route('voyager.dashboard');
        }

        return Voyager::view('voyager::forget_password');
    }

    public function postforget_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $user = User::where('email', $request->email)->whereIn('role_id',
            [getRoleID('admin'), getRoleID('manager'), getRoleID('accountant')])->first();

        if (!$user) {
            return redirect()->back()->with([
                'message' => trans('messages.Enter your email!'),
                'alert-type' => 'error',
            ]);
            return parent::sendError([['message' => trans('messages.incorrect phone')]], 403);
        }

        PasswordReset::where([
            'phone' => $request->email
        ])->delete();

        $token = generateRandomCode();

        $pr = new PasswordReset();
        $pr->phone = $request->email;
        $pr->code = $token;
        $pr->created_at = Carbon::now()->toDateTimeString();
        $pr->save();

        try {
            Mail::to($user->email)->send(new \App\Mail\PasswordResetMail($token));
        } catch (\Exception $ex) {

        }

        return redirect()->route('voyager.reset_password',[
            'email'=>$request->email
        ]);

    }

    public function reset_password()
    {
        if ($this->guard()->user()) {
            return redirect()->route('voyager.dashboard');
        }

        return Voyager::view('voyager::reset_password');
    }

    public function postreset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'code' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with([
                'message' => trans('messages.Error in sent Data!'),
                'alert-type' => 'error',
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with([
                'message' => trans('messages.Error in sent Data!'),
                'alert-type' => 'error',
            ]);
        }

        $pr = PasswordReset::where([
            'phone' => $request->email,
            'code' => $request->code
        ])->first();

        if ($pr) {
            $user->password = bcrypt($request->password);
            $user->update();
            $pr->delete();
            return redirect()->route('voyager.login')->with([
                'message' => trans('messages.Password Reset Successfully!'),
                'alert-type' => 'error',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => trans('messages.Error in the token sent'),
                'alert-type' => 'error',
            ]);
        }

    }

    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'code' => 'required|string',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with([
                'message' => trans('messages.Error in sent Data!'),
                'alert-type' => 'error',
            ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return redirect()->back()->with([
                'message' => trans('messages.Error in sent Data!'),
                'alert-type' => 'error',
            ]);
        };


        $pr = PasswordReset::where([
            'phone' => $request->phone,
            'code' => $request->code
        ])->first();

        if ($pr) {
            $user->password = bcrypt($request->password);
            $user->update();
            $pr->delete();
            return redirect()->route('voyager.login')->with([
                'message' => trans('messages.Password Reset Successfully!'),
                'alert-type' => 'success',
            ]);
        } else {
            return parent::sendError([['message' => trans('messages.Error in the token sent')]], 403);
        }
    }

    public function postLogin(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /*
     * Preempts $redirectTo member variable (from RedirectsUsers trait)
     */
    public function redirectTo()
    {
        return config('voyager.user.redirect', route('voyager.dashboard'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard(app('VoyagerGuard'));
    }
}
