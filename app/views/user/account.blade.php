@extends('layouts.default')
@section('page')
<h2>
    {{{ $user->getFullname() }}}
</h2>
{{ Form::model($user, ['route' => 'account', 'class' => 'account-form']) }}
    <dl>
        <dt>{{ Form::label('account-username', 'Username') }}</dt>
        <dd>{{ $user->username }}</dd>
        <dt>{{ Form::label('account-firstname', 'First Name') }}</dt>
        <dd>{{ Form::text('firstname', null, ['id'=>'account-firstname']) }}</dd>
        <dd class="error_text">{{ $errors->first('firstname') }}</dd>
        <dt>{{ Form::label('account-lastname', 'Last Name') }}</dt>
        <dd>{{ Form::text('lastname', null, ['id'=>'account-lastname']) }}</dd>
        <dd class="error_text">{{ $errors->first('lastname') }}</dd>
        <dt>{{ Form::label('account-email', 'Email address') }}</dt>
        <dd>{{ Form::text('email', null, ['id'=>'account-email']) }}</dd>
        <dd class="error_text">{{ $errors->first('email') }}</dd>
        <dt>{{ Form::label('account-password', 'Password') }}</dt>
        <dd>{{ Form::password('password', '', ['id'=>'account-password']) }}</dd>
        <dd class="error_text">{{ $errors->first('password') }}</dd>
        <dt>{{ Form::label('account-password2', 'Confirm') }}</dt>
        <dd>{{ Form::password('password2', '', ['id'=>'account-password2']) }}</dd>
        <dd class="error_text">{{ $errors->first('password2') }}</dd>
    </dl>
{{ Form::submit('looks good to me, boss', ['name' => 'submit']) }}
{{ Form::close() }}
@stop