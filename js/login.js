function LoginForm(element) {
    this.element = $(element);
    this.form = $(element).find('.login-form');
    if (!this.form.length) {
        throw new Error ('expected login form');
    }
    this.form.on('submit', this.login.bind(this));
}

LoginForm.prototype.hide = function() {
    this.element.hide();
};

LoginForm.prototype.show = function() {
    this.element.show();
};

LoginForm.prototype.login = function(e) {
    e.preventDefault();
    if (this.request) {
        return;
    }
    this.request = $.ajax({
        url: this.form.attr('action'),
        type: 'POST',
        data: this.form.serialize(),
        beforeSend: function() {
            this.form.find('.error_text').empty().hide();
        }.bind(this),
        error:function() {
            this.error();
        }.bind(this),
        success: function(data) {
            if (!data.success) {
                this.error(data.error);
            } else {
                window.location.href = data.redirect;
            }
        }.bind(this),
        complete: function() {
            this.request = null;
        }.bind(this)
    });
};

LoginForm.prototype.error = function(error) {
    if (!error) {
        error = 'An error occurred.';
    }
    this.element.find('.error_text').text(error).show();
};

function SignupForm(element) {
    this.element = $(element);
    this.form = $(element).find('.signup-form');
    if (!this.form.length) {
        throw new Error ('expected login form');
    }
    this.form.on('submit', this.signup.bind(this));
}

SignupForm.prototype.hide = function() {
    this.element.hide();
};

SignupForm.prototype.show = function() {
    this.element.show();
};

SignupForm.prototype.signup = function(e) {
    e.preventDefault();
    if (this.request) {
        return;
    }
    this.request = $.ajax({
        url: this.form.attr('action'),
        type: 'POST',
        data: this.form.serialize(),
        beforeSend: function() {
            this.form.find('.has_error').removeClass('has_error').end()
                .find('.error_text, .error_text_generic').empty().hide();
        }.bind(this),
        error:function() {
            this.errors();
        }.bind(this),
        success: function(data) {
            if (!data.success) {
                this.errors(data.errors);
            } else {
                window.location.href = data.redirect;
            }
        }.bind(this),
        complete: function() {
            this.request = null;
        }.bind(this)
    });
};

SignupForm.prototype.errors = function(errors) {
    if (!errors) {
        errors = ['An error occurred.'];
    }
    for (var i in errors) {
        var target = (typeof i === 'string')
            ? '.error_text[data-for="'+i+'"]'
            : '.error_text_generic';
        this.form.find(target).text(errors[i]).show();
    }
};

function LoginPage(login, signup) {
    if (!(login instanceof LoginForm)) {
        throw new TypeError('expect login form');
    }
    if (!(signup instanceof SignupForm)) {
        throw new TypeError('expect signup form');
    }
    this.login = login;
    this.signup = signup;
}

LoginPage.prototype.init = function() {
    this.login.element.find('.signup-switch').on('click', function() {
        this.login.hide();
        this.signup.show();
    }.bind(this));

    this.signup.element.find('.login-switch').on('click', function() {
        this.signup.hide();
        this.login.show();
    }.bind(this));
};

$(function() {
    if ($('[data-page="landing"]').length) {
        var login = new LoginForm('.landing .landing-login');
        var signup = new SignupForm('.landing .landing-signup');
        var page = new LoginPage(login, signup);
        page.init();
    }
});

/** @todo spinners! */