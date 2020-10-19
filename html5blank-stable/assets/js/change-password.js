const changePassword = {
    bind: function(root) {
        let that = this;
        let changePassword = document.getElementById('change-password');

        if (!changePassword) {
            return false;
        }

        changePassword.addEventListener('submit', function(e) {
            e.preventDefault();
            that.sendForm();
        });
    },

    sendForm: function() {
	    let pass1el = document.getElementById('pass1');
	    let pass2el = document.getElementById('pass2');
        let pass1 = pass1el.value;
        let pass2 = pass2el.value;
        let messagesUl = document.getElementById('change-password-messages');
        messagesUl.innerHTML = '';
        let error = false;

        if (pass1 !== pass2) {
            error = true;
            let li = document.createElement('li');
            li.classList.add('error');
            li.innerHTML = 'Lösenorden stämmer inte överens.';
            messagesUl.appendChild(li);
        }

        if (pass2.length < 7) {
            error = true;
            let li = document.createElement('li');
            li.classList.add('error');
            li.innerHTML = 'Lösenordet är för kort. Vänligen ange minst 7 tecken.';
            messagesUl.appendChild(li);
        }

        if (error) {
            return false;
        }

        $('.form-changepassword-button').html('Ändrar lösenord <i class="fa fa-spin fa-circle-notch" aria-hidden="true"></i>').attr('disabled', true);
        $.ajax({
            url: cvars.ajaxurl,
            method: 'POST',
            data: 'action=changepassword&pass1=' + pass1 + '&pass2=' + pass2
        }).done(function(resp) {
            var data = JSON.parse(resp);
            if (data.status === 'NOK') {
                const errors = data.errors.errors;
                for (let key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        let li = document.createElement('li');
                        li.classList.add('error');
                        li.innerHTML = errors[key];
                        messagesUl.appendChild(li);
                    }
                }
            } else if (data.status === 'OK') {
		        pass1el.value = '';
                pass2el.value = '';
                $('#login-container').fadeToggle('fast', function() {
                    $(this).find('#login-box').prepend('<p id="change-pass-success">Ditt lösenord har ändrats! Vänligen logga in igen</p>');
                });
            }
        }).fail(function(error) {
            $(messagesUl).append('<li class="error">Något gick fel, var god försök igen senare.</li>');
        }).always(function() {
            $('.form-changepassword-button').text('Ändra lösenord').attr('disabled', false);
        });
    }
};

(function() {
    changePassword.bind();
})();
