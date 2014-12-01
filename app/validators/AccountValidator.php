<?php
namespace cram\validators;
class AccountValidator extends AbstractValidator
{

    protected $rules = [
        'firstname' => 'required|alpha',
        'lastname' => 'required|alpha',
        'email' => 'required|email|unique:users,email,{id}',
        'password' => 'min:8|max:255',
        'password2' => 'same:password',
    ];

}