$(document).ready(function() {

    //$('.date').mask('00/00/0000');

    /*DROPIFY*/

    // Basic
    //$('.dropify').dropify();
    // Translated
    $('.dropify').dropify({
        messages: {
            default: 'Перетащите файл или нажмите для выбора',
            replace: 'Перетащите файл или нажмите для выбора нового файла',
            remove: 'УДАЛИТЬ',
            error: 'Ошибка'
        }
    });
    // Used events
    var drEvent = $('#input-file-events').dropify();
    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Вы уверены что хотите удалить  \"" + element.file.name + "\" ?");
    });
    drEvent.on('dropify.afterClear', function(event, element) {
        alert('Файл удален!');
    });
    drEvent.on('dropify.errors', function(event, element) {
        //console.log('Has Errors');
    });
    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function(e) {
        e.preventDefault();
        if (drDestroy.isDropified()) {
            drDestroy.destroy();
        } else {
            drDestroy.init();
        }
    })

    /*DATEPICKER*/

    $('.mydatepicker, #datepicker').datepicker({
        format: 'yyyy-mm-dd',
        //minDate: '01-01-1950',
        //maxDate: '06/30/2015',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        dateLimit: {
            days: 6
        }
    });

});