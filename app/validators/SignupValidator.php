<?php
namespace cram\validators;
class SignupValidator extends AbstractValidator
{

    protected $rules = [
        'username' => 'required|min:4|max:16|alpha_dash|unique:users',
        'firstname' => 'required|alpha',
        'lastname' => 'required|alpha',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|max:255',
        'password2' => 'required|same:password',
    ];

}