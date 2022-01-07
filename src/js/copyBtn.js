function copyEnrollBtn__init(btnid, inputid) {
    $(`#${btnid}`).on('click', function () {
        $(`#${inputid}`).select()
        document.execCommand('Copy');
    })
}