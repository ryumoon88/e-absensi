$(document).ready(function () {
    var firstNameEditBtn = $('button[name=editfn]#firstnameBtn');
    var lastnameEditBtn = $('button[name=editln]#lastnameBtn')
    var passwordEditBtn = $('button[name=editpw]#passwordBtn');
    var emailEditBtn = $('button[name=editemail]#emailBtn');
    var passVerifyButton = $('button[name=verify]');

    var hidFirstName = $('input[name=hiddenFirstname]');
    var hidLastName = $('input[name=hiddenLastname]');
    var hidPassword = $('input[name=hiddenPassword');
    var hidEmail = $('input[name=hiddenEmail]');

    var firstNameInput = $('input#firstname');
    var lastNameInput = $('input#lastname');
    var passwordInput = $('input#password');
    var repeatPassInput = $('input#repeatpass');
    var emailInput = $('input#email')

    var fnOldVal = firstNameInput.val();
    var flOldVal = lastNameInput.val();
    var passOldVal = passwordInput.val();
    var emailOldVal = emailInput.val()

    firstNameEditBtn.click(function () {
        if (firstNameEditBtn.attr('name') == 'editfn') {
            firstNameEditBtn.text('Cancel')
            firstNameEditBtn.attr('name', 'cancelfn');
            firstNameInput.removeAttr('disabled')
            firstNameInput.select();
            return;
        }
        if (firstNameEditBtn.attr('name') == 'savefn') {
            firstNameEditBtn.text('Edit');
            firstNameEditBtn.attr('name', 'editfn');
            firstNameInput.attr('disabled', 1);
            return;
        }
        if (firstNameEditBtn.attr('name') == 'cancelfn') {
            if (!firstNameInput.val()) firstNameInput.val(fnOldVal);
            firstNameEditBtn.text('Edit');
            firstNameEditBtn.attr('name', 'editfn')
            firstNameInput.attr('disabled', 1)
            return;
        }
    })

    firstNameInput.keyup(function () {
        hidFirstName.val(firstNameInput.val());
        if (!firstNameInput.val() || firstNameInput.val() === fnOldVal) {
            firstNameEditBtn.text('Cancel');
            firstNameEditBtn.attr('name', 'cancelfn');
            firstNameEditBtn.attr('type', 'button');
            return
        } else {
            firstNameEditBtn.text('Save')
            firstNameEditBtn.attr('name', 'savefn');
            firstNameEditBtn.attr('type', 'submit');
            return;
        }
    })

    lastnameEditBtn.click(function () {
        if (lastnameEditBtn.attr('name') == 'editln') {
            lastnameEditBtn.text('Cancel')
            lastnameEditBtn.attr('name', 'cancelln');
            lastNameInput.removeAttr('disabled')
            lastNameInput.select();
            return;
        }
        if (lastnameEditBtn.attr('name') == 'saveln') {
            lastnameEditBtn.text('Edit');
            lastnameEditBtn.attr('name', 'editln');
            lastNameInput.attr('disabled', 1);
            return;
        }
        if (lastnameEditBtn.attr('name') == 'cancelln') {
            if (!firstNameInput.val()) firstNameInput.val(flOldVal);
            lastnameEditBtn.text('Edit');
            lastnameEditBtn.attr('name', 'editln')
            lastNameInput.attr('disabled', 1)
            return;
        }
    })

    lastNameInput.keyup(function () {
        hidLastName.val(lastNameInput.val());
        if (!lastNameInput.val() || lastNameInput.val() === flOldVal) {
            lastnameEditBtn.text('Cancel');
            lastnameEditBtn.attr('name', 'cancelln');
            lastnameEditBtn.attr('type', 'button');
            return;
        } else {
            lastnameEditBtn.text('Save')
            lastnameEditBtn.attr('name', 'saveln');
            lastnameEditBtn.attr('type', 'submit');
            return;
        }
    })

    passwordEditBtn.click(function () {
        if (passwordEditBtn.attr('name') == 'editpw') {
            passwordEditBtn.text('Cancel')
            passwordEditBtn.attr('name', 'cancelpw');
            passwordInput.removeAttr('disabled')
            passwordInput.select();
            return;
        }
        if (passwordEditBtn.attr('name') == 'savepw') {
            passwordEditBtn.text('Edit');
            passwordEditBtn.attr('name', 'editpw');
            passwordInput.attr('disabled', 1);
            passVerifyButton.html("<i class='bi bi-x-circle text-white' style='font-size: 25px;'></i>")
            passVerifyButton.removeClass('btn-success');
            passVerifyButton.addClass('btn-danger');
            repeatPassInput.val('');
            return;
        }
        if (passwordEditBtn.attr('name') == 'cancelpw') {
            if (!passwordInput.val()) passwordInput.val(passOldVal);
            passwordEditBtn.text('Edit');
            passwordEditBtn.attr('name', 'editpw')
            passwordInput.attr('disabled', 1)
            repeatPassInput.val('');
            return;
        }
    })

    passwordInput.keyup(function () {
        hidPassword.val(passwordInput.val())
        if (!passwordInput.val() || passwordInput.val() === passOldVal) {
            passwordEditBtn.text('Cancel');
            passwordEditBtn.attr('name', 'cancelpw');
            passwordEditBtn.removeAttr('disabled')
            passwordEditBtn.attr('type', 'button');
            return;
        } else if (passwordInput.val() === repeatPassInput.val() && passwordInput.val()) {
            passVerifyButton.removeClass('btn-danger');
            passVerifyButton.addClass('btn-success')
            passVerifyButton.html("<i class='bi bi-check-circle-fill text-white' style='font-size: 25px;'></i>")
            passwordEditBtn.text('Save');
            passwordEditBtn.attr('name', 'savepw');
            passwordEditBtn.attr('type', 'submit');
            return;
        }
        else {
            passwordEditBtn.text('Cancel')
            passwordEditBtn.attr('name', 'cancelpw');
            passVerifyButton.removeClass('btn-success')
            passVerifyButton.addClass('btn-danger');
            passVerifyButton.html("<i class='bi bi-x-circle text-white' style='font-size: 25px;'></i>")
            passwordEditBtn.attr('type', 'button');
            return;
        }
    })

    repeatPassInput.keyup(function () {
        if (passwordInput.val() === repeatPassInput.val()) {
            passVerifyButton.removeClass('btn-danger');
            passVerifyButton.addClass('btn-success')
            passVerifyButton.html("<i class='bi bi-check-circle-fill text-white' style='font-size: 25px;'></i>")
            passwordEditBtn.text('Save');
            passwordEditBtn.attr('name', 'savepw');
            passwordEditBtn.attr('type', 'submit');
            return;
        } else {
            passVerifyButton.removeClass('btn-success')
            passVerifyButton.addClass('btn-danger');
            passVerifyButton.html("<i class='bi bi-x-circle text-white' style='font-size: 25px;'></i>")
            passwordEditBtn.text('Cancel');
            passwordEditBtn.attr('name', 'cancelpw');
            passwordEditBtn.attr('type', 'button');
            return;
        }
    })

    emailEditBtn.click(function () {
        if (emailEditBtn.attr('name') == 'editemail') {
            emailEditBtn.text('Cancel')
            emailEditBtn.attr('name', 'cancelemail');
            emailInput.removeAttr('disabled')
            emailInput.select();
            return;
        }
        if (emailEditBtn.attr('name') == 'saveemail') {
            emailEditBtn.text('Edit');
            emailEditBtn.attr('name', 'editemail');
            emailInput.attr('disabled', 1);
            return;
        }
        if (emailEditBtn.attr('name') == 'cancelemail') {
            if (!emailInput.val()) emailInput.val(emailOldVal);
            emailEditBtn.text('Edit');
            emailEditBtn.attr('name', 'editemail')
            emailInput.attr('disabled', 1)
            return;
        }
    })

    emailInput.keyup(function () {
        hidEmail.val(emailInput.val());
        if (!emailInput.val() || emailInput.val() === emailOldVal) {
            emailEditBtn.text('Cancel');
            emailEditBtn.attr('name', 'cancelemail');
            // emailEditBtn.attr('type', 'button');
            return;
        } else {
            emailEditBtn.text('Save')
            emailEditBtn.attr('name', 'saveemail');
            emailEditBtn.attr('type', 'submit');
            return;
        }
    })
})