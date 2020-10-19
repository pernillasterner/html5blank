const loginFormHandler = {
    resetKey: null,
    resetLogin: null,

    init: function() {
        this.bind();
        this.checkUrl();
    },

    bind: function() {
        let that = this;

        document.getElementById('lostpassword-link').addEventListener('click', function(e) {
            e.preventDefault();
            that.toggleVisiblePart('lostpassword-form');
        });

        document.getElementById('lp-form').addEventListener('submit', function(e) {
            e.preventDefault();
            that.sendForm();
        });

        document.getElementById('lp-reset-form').addEventListener('submit', function(e) {
            e.preventDefault();
            that.sendResetForm();
        });

        let backToLogin = document.getElementsByClassName('back-to-login');
        for (let i = 0; i < backToLogin.length; i++) {
            (function(index) {
                backToLogin[index].addEventListener('click', function(e) {
                    e.preventDefault();
                    that.toggleVisiblePart('login-form');
                    that.resetForm(false);
                });
            })(i);
        }
    },

    checkUrl: function() {
        let url = window.location.href;
        if (url.indexOf('#reset-password') > -1) {
            let matches = url.match(/\&key\=(.*)&login=(.*)/);
            this.resetKey = matches[1];
            this.resetLogin = matches[2];
            document.getElementById('lp-reset-name').innerHTML = this.resetLogin;
            this.toggleVisiblePart('lostpassword-reset-form');
            jQuery('#login-container').fadeToggle('fast', function() {});
        }
    },

    toggleVisiblePart: function(id) {
        let elements = document.getElementsByClassName('login-modal-part');
        for (let i = 0; i < elements.length; i++) {
            if (elements[i].id !== id) {
                elements[i].classList.add('hidden');
            } else {
                elements[i].classList.remove('hidden');
            }
        }
    },

    resetForm: function(close) {
        let that = this;
        if (close) {
            jQuery('#login-container').fadeToggle('fast', function() {
                that.toggleVisiblePart('login-form');
                document.getElementById('lp-user-login').value = '';
                document.getElementById('lp-error').innerHTML = '';
            });
        } else {
            document.getElementById('lp-user-login').value = '';
            document.getElementById('lp-pass-1').value = '';
            document.getElementById('lp-pass-2').value = '';
            document.getElementById('lp-error').innerHTML = '';
        }
    },

    sendForm: function() {
        let that = this;
        let email = document.getElementById('lp-user-login').value;
        let lpError = document.getElementById('lp-error');
        lpError.innerHTML = '';

        $.ajax({
            url: vars.ajaxurl,
            method: 'POST',
            data: 'action=lostpassword&user_login=' + email
        }).done(function(resp) {
            var data = JSON.parse(resp);

            if (data.status === 'NOK') {
                const errors = data.errors.errors;
                for (let key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        let li = document.createElement('li');
                        li.innerHTML = errors[key];
                        lpError.appendChild(li);
                    }
                }
            } else if (data.status === 'MNOK') {
                that.toggleVisiblePart('lostpassword-error');
            } else if (data.status === 'OK') {
                that.toggleVisiblePart('lostpassword-success');
            }
        });
    },

    sendResetForm: function() {
        let that = this;
        let pass1 = document.getElementById('lp-pass-1').value;
        let pass2 = document.getElementById('lp-pass-2').value;
        let lpResetError = document.getElementById('lp-reset-error');
        lpResetError.innerHTML = '';
        let error = false;

        if (pass1 !== pass2) {
            error = true;
            let li = document.createElement('li');
            li.innerHTML = 'Lösenorden stämmer inte överens.';
            lpResetError.appendChild(li);
        }

        if (pass1.length < 7) {
            error = true;
            let li = document.createElement('li');
            li.innerHTML = 'Lösenordet är för kort. Vänligen ange minst 7 tecken.';
            lpResetError.appendChild(li);
        }

        if (error) {
            return false;
        }

        $.ajax({
            url: vars.ajaxurl,
            method: 'POST',
            data: 'action=resetpassword&key=' + that.resetKey + '&login=' + that.resetLogin + '&pass1=' + pass1 + '&pass2=' + pass2
        }).done(function(resp) {
            var data = JSON.parse(resp);

            if (data.status === 'NOK') {
                const errors = data.errors.errors;
                for (let key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        let li = document.createElement('li');
                        li.innerHTML = errors[key];
                        lpResetError.appendChild(li);
                    }
                }
            } else if (data.status === 'OK') {
                that.toggleVisiblePart('lostpassword-reset-success');
            }
        });
    }
};

(function() {
    loginFormHandler.init();
})();
