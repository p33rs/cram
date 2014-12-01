@extends('layouts.base')

@section('content')

<div class="landing">
    <section class="landing-login login">
        <aside class="error_text"></aside>
        {{ Form::open(['route' => 'login', 'class' => 'login-form']) }}
            <dl>
                <dt>
                    {{ Form::label('login-username', 'Username') }}
                </dt>
                <dd>
                    {{ Form::text('username', '', ['id'=>'login-username']) }}
                </dd>
                <dt>
                    {{ Form::label('login-password', 'Password') }}
                </dt>
                <dd>
                    {{ Form::password('password', '', ['id'=>'login-password']) }}
                </dd>
                <dt>
                    {{ Form::label('login-remember', 'Remember Me') }}
                </dt>
                <dd>
                    {{ Form::checkbox('remember', '', ['id'=>'login-remember']) }}
                </dd>
            </dl>
            {{ Form::submit('Get Crammin\'') }}
        {{ Form::close() }}
        <button class="signup-switch">Sign Up</button>
    </section>

    <section class="landing-signup signup">
        <aside class="error_text_generic"></aside>
        {{ Form::open(['route' => 'signup', 'class' => 'signup-form']) }}
            <dl>
                <dt>{{ Form::label('signup-username', 'Username') }}</dt>
                <dd>{{ Form::text('username', '', ['id'=>'signup-username']) }}</dd>
                <dd class="error_text" data-for="username"></dd>
                <dt>{{ Form::label('signup-firstname', 'First Name') }}</dt>
                <dd>{{ Form::text('firstname', '', ['id'=>'signup-firstname']) }}</dd>
                <dd class="error_text" data-for="firstname"></dd>
                <dt>{{ Form::label('signup-lastname', 'Last Name') }}</dt>
                <dd>{{ Form::text('lastname', '', ['id'=>'signup-lastname']) }}</dd>
                <dd class="error_text" data-for="lastname"></dd>
                <dt>{{ Form::label('signup-email', 'Email address') }}</dt>
                <dd>{{ Form::text('email', '', ['id'=>'signup-email']) }}</dd>
                <dd class="error_text" data-for="email"></dd>
                <dt>{{ Form::label('signup-password', 'Password') }}</dt>
                <dd>{{ Form::password('password', '', ['id'=>'signup-password']) }}</dd>
                <dd class="error_text" data-for="password"></dd>
                <dt>{{ Form::label('signup-password2', 'Confirm') }}</dt>
                <dd>{{ Form::password('password2', '', ['id'=>'signup-password2']) }}</dd>
                <dd class="error_text" data-for="password2"></dd>
            </dl>
        {{ Form::submit('Start Crammin\'') }}
        {{ Form::close() }}
        <button class="login-switch">Log in</button>
    </section>
</div>
@stop