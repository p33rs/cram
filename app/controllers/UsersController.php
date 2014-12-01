<?php

class UsersController extends BaseController {

    public function login()
    {
        $username = Input::get('username');
        $password = Input::get('password');
        $remember = Input::get('remember');
        $error = '';
        if (!$username) {
            $error = 'Please enter your username.';
        } elseif (!$password) {
            $error = 'Please enter your password.';
        } elseif (!Auth::check() && !Auth::attempt(['username' => $username, 'password' => $password], $remember)) {
            $error = 'An invalid username or password was provided.';
        }
        $result = [ 'success' => !$error, 'error' => $error ];
        if (!$error) {
            $result['redirect'] = URL::route('photos');
        }
        return Response::json($result);
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('landing');
    }

    public function signup()
    {
        /** @var cram\validators\ValidatorLocator $validators */
        $validators = App::make('cram\Validation');
        $data = Input::all();
        /** @var cram\validators\SignupValidator $validator */
        $errors = $validators->get('Signup', $data)->errors();
        $result = [ 'errors' => $errors ];
        if ($errors->count()) {
            $result += ['success' => false];
        } else {
            unset($data['password2']);
            $user = new User($data);
            $user->password = Hash::make($data['password']);
            $user->save();
            Auth::login($user);
            $result += [
                'success' => true,
                'redirect' => URL::route('photos')
            ];
        }
        return Response::json($result);
    }

    public function account()
    {
        return View::make('users/account');
    }

    public function accountSave()
    {

    }

    public function follow()
    {

    }

}
