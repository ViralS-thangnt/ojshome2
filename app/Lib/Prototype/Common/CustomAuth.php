<?php namespace App\Lib\Prototype\Common;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

trait CustomAuth
{
    use AuthenticatesAndRegistersUsers;

    public function postRegister(UserRequest $request)
    {

        $this->auth->login($this->registrar->create($request->all()));

        return redirect($this->redirectPath());
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => $this->getFailedLoginMessage(),
                    ]);
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : REDIRECT_PATH;
    }

    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : LOGIN_PATH;
    }

    protected function getFailedLoginMessage()
    {
        return trans('admin.FailedLoginMessage');
    }
}
