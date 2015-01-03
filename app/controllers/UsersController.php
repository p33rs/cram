<?php

use cram\response\JsonResponse;
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
        return $error ? JsonResponse::error($error) : JsonResponse::success(Auth::user());
    }

    public function logout()
    {
        Auth::logout();
        return JsonResponse::success();
    }

    public function signup()
    {
        /** @var cram\validators\ValidatorLocator $validators */
        $validators = App::make('cram\Validation');
        $data = Input::all();
        /** @var cram\validators\SignupValidator $validator */
        $errors = $validators->get('Signup', $data)->errors();
        if ($errors->count()) {
            return JsonResponse::validation($errors);
        }
        unset($data['password2']);
        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();
        Auth::login($user);
        return JsonResponse::success(Auth::user());
    }

    public function read($username = null)
    {
    }

    public function update()
    {
        $user = Auth::user();
        if (!Request::isMethod('post')) {
            return View::make('user/account')->with('user', $user);
        }
        $data = Input::all();
        /** @var cram\validators\ValidatorLocator $validators */
        $validators = App::make('cram\Validation');
        /** @var cram\validators\SignupValidator $validator */
        $errors = $validators->get('Account', $data, ['id' => $user->id])->errors();
        $user->email = Input::get('email');
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        if (Input::get('password')) {
            $user->password = Hash::make($data['password']);
        }
        if (!$errors->count()) {
            $user->save();
            Session::set('message', 'Account updated');
        }
        return View::make('user/account')
            ->with('user', $user)
            ->with('errors', $errors);
    }

    public function follow($username)
    {
        $follower = Auth::user();
        return JsonResponse::success();
    }

    public function unfollow($username)
    {
        return JsonResponse::success();
    }

}
