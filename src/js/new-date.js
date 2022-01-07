var datetimeFormat = 'YYYY-MM-DD\THH:mm';

var config = {
    enableTime: true,
    altInput: true,
    minDate: moment().format(datetimeFormat),
    altFormat: 'D, d F Y - H:i',
    time_24hr: true,
    dateFormat: 'Y-m-d\TH:i'
}

$(document).ready(function () {
    // get needed element
    var flatpickrInputFields = flatpickr('input[type=datetime-local]', config)

    var openOption = $('input[name=opendatecheck]');
    var closeOption = $('input[name=closedatecheck]');
    var openInputField = $('#datepicker-open');
    var closeInputField = $('#datepicker-close');
    var flatpickrOpenInput = flatpickrInputFields.find(e => e.input.id === 'opendateinput');
    var flatpickrCloseInput = flatpickrInputFields.find(e => e.input.id === 'closedateinput');
    flatpickrOpenInput.set('maxDate', moment().add(1, 'M').format(datetimeFormat));
    flatpickrCloseInput.set('maxDate', moment().add(1, 'M').add(10, 'm').format(datetimeFormat));
    var openInput = $(`#${flatpickrOpenInput.input.id}`);
    var closeInput = $(`#${flatpickrCloseInput.input.id}`);

    // Menampilkan open date input saat nilai option Custom.
    openOption.on('change', function () {
        if ($(this).val() === 'Custom') {
            openInput.val(moment().format(datetimeFormat))
            flatpickrOpenInput.setDate(moment().format(datetimeFormat));
            openInputField.addClass('show');
        } else {
            openInput.val('');
            flatpickrCloseInput.set('minDate', moment().add(10, 'm').format(datetimeFormat));
            flatpickrOpenInput.setDate('');
            openInputField.removeClass('show');
            console.log(openInput.val())
        }
    })

    closeOption.on('change', function () {
        if ($(this).val() === 'Custom') {
            var defaultTime = moment().add(10, 'm').format(datetimeFormat);
            console.log(openInput.val());
            if (openInput.val()) defaultTime = moment(openInput.val()).add(10, 'm').format(datetimeFormat);
            flatpickrCloseInput.setDate(defaultTime);
            closeInput.val(defaultTime);
            closeInputField.addClass('show');
        } else {
            closeInput.val('');
            flatpickrCloseInput.setDate('');
            closeInputField.removeClass('show');
            console.log(closeInput.val())
        }
    })

    openInput.on('change', function () {
        if (closeInput.val()) {
            var defaultTime = moment(openInput.val()).add(10, 'm').format(datetimeFormat);
            flatpickrCloseInput.set('minDate', defaultTime);
            closeInput.val(defaultTime)
            flatpickrCloseInput.setDate(defaultTime)
        }
    })
})