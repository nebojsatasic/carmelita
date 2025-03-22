<?php

class AuthController extends Controller
{
    /**
     * Display login form
     *
     * @return self
     */
    public function showLogin()
    {
        return self::view('auth/login');
    }    

    /**
     * Login users
     *
     * @return Redirect
     */
    public function login()
    {
        $params = ArrayHelper::clean($_POST);

        if (isset($params['username'], $params['password'])) {
            $rules = [
                'username' => ['required'],
                'password' => ['required', 'minLen' => 6]
            ];

            $validator = new Validator();
            $validator->validate($params, $rules);

            if ($validator->getErrors()) {
                $validator->showErrors();
                unset($params['password']);
                return Redirect::withInput($params)->to('Auth/showLogin');
            }

            if (Auth::attempt($params['username'], $params['password']))
            {
                if (Auth::isAdmin()) {
                    return Redirect::withSuccess('Hi Admin! You\'re logged in')->to('AdminProduct/index');
                } else {
                    return Redirect::withSuccess('You\'re logged in')->to('Product/index');
                }
            } else {
                Return Redirect::withError('Wrong username or password')->to('Auth/showLogin');
            }

        } else {
            return Redirect::withError('All required parameters must be sent')->to('Auth/showLogin');
        }
    }

    /**
     * Logging out
     *
     * @return Redirect
     */
    public function logout()
    {
        Auth::logout();
        return Redirect::to('Auth/showLogin');
    }

    /**
     * Display register form
     *
     * @return self
     */
    public function showRegister()
    {
        return self::view('auth/register');
    }

    /**
     * Register users
     *
     * @return Redirect
     */
    public function register()
    {
        $params = ArrayHelper::clean($_POST);

        if (isset($params['name'], $params['username'], $params['email'], $params['password'], $params['password_confirmation'])) {
            $rules = [
                'name' => ['required'],
                'username' => ['required', 'unique' => 'User'],
                'email' => ['required', 'email', 'unique' => 'User'],
                'password' => ['required', 'minLen' => 6, 'confirmation' => 'password_confirmation']
            ];

            $validator = new Validator();
            $validator->validate($params, $rules);

            if ($validator->getErrors()) {
                $validator->showErrors();
                unset($params['password'], $params['password_confirmation']);
                return Redirect::withInput($params)->to('Auth/showRegister');
            }

            $user = new User();
            $user->name = $params['name'];
            $user->username = $params['username'];
            $user->email = $params['email'];
            $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
            $user->created_at = date('Y-m-d H:i:s', time());

            if ($user->create()) {
                Auth::attempt($params['username'], $params['password']);
                return Redirect::withSuccess('You registered successfully')->to('Product/index');
            } else {
                return Redirect::withError('You didn\'t register. Try again.')->to('Auth/showRegister');
            }

        } else {
            return Redirect::withError('All required parameters must be sent')->to('Auth/showLogin');
        }
    }
}
