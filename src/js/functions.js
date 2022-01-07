function oneTimeButton(btnId) {
    $(`#${btnId}`).on('click', function () {
        $(this).addClass('disabled');
    })
}