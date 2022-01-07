$(document).ready(function () {
    var keywordActiveAbsence = $('#searchActiveAbsence')
    var tbodyActiveAbsence = $('#tbodyactive')

    var tbodyMyAbsence = $('#tbodymyabsence')
    var keywordMyAbsence = $('#searchMyAbsence')

    var tbodyRecord = $('#tbodyrecord');
    var keywordRecord = $('#searchrecord');
    var absenceID = $('#absid').text().split(' ')[1];

    console.log(absenceID)

    keywordActiveAbsence.keyup(function () {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                tbodyActiveAbsence.html(xhr.responseText);
            }
        }
        xhr.open('GET', '../../../src/ajax/active.php?q=' + keywordActiveAbsence.val())
        xhr.send()
    })

    keywordMyAbsence.keyup(function () {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                tbodyMyAbsence.html(xhr.responseText);
                console.log(xhr.responseText)
            }
        }
        xhr.open('GET', '../../../src/ajax/myabsence.php?q=' + keywordMyAbsence.val())
        xhr.send()
    })

    keywordRecord.keyup(function () {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                tbodyRecord.html(xhr.responseText)
            }
        }
        xhr.open('GET', '../../../../src/ajax/record.php?id=' + absenceID + '&q=' + keywordRecord.val());
        xhr.send();
    })
})