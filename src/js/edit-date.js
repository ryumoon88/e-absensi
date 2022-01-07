var datetimeFormat = 'YYYY-MM-DD\THH:mm';

var config = {
    enableTime: true,
    altInput: true,
    altFormat: 'D, d F Y - H:i',
    time_24hr: true,
    dateFormat: 'Y-m-d\TH:i',
    allowInvalidPreload: true
}

$(document).ready(function () {
    var flatpickeredInputFields = flatpickr('input[type=datetime-local]', config);

    var flatpickrOpenInput = flatpickeredInputFields.find(e => e.input.id == 'absenceopened')
    var flatpickrCloseInput = flatpickeredInputFields.find(e => e.input.id == 'absenceexpired')

    var real_openInput = $(`#${flatpickrOpenInput.input.id}`);
    var real_closeInput = $(`#${flatpickrCloseInput.input.id}`);
    var real_createInput = $('input[name=absencecreated]').val();

    var absence_status = $('select[name=absencestatus]').find(':selected').val();
    var minOpenDate = (absence_status == 'Opened') ? $('input[name=absencecreated]').val() : moment().format(datetimeFormat);
    var minCloseDate = (absence_status == 'Opened') ? moment().add(10, 'm').format(datetimeFormat) : moment(minOpenDate).add(10, 'm').format(datetimeFormat);
    var now = moment().format(datetimeFormat);
    flatpickrOpenInput.set('minDate', minOpenDate);
    flatpickrCloseInput.set('minDate', minCloseDate);

    real_openInput.on('change', function () {
        var defaultCloseTime = moment($(this).val()).add(10, 'm').format(datetimeFormat)
        real_closeInput.val(defaultCloseTime);
        flatpickrCloseInput.setDate(defaultCloseTime)
        flatpickrCloseInput.set('minDate', defaultCloseTime)
    })
})