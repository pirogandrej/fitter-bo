$(document).ready(function () {

    /*DROPIFY*/

    $('.dropify').dropify({
        messages: {
            default: 'Перетащите файл или нажмите для выбора',
            replace: 'Перетащите файл или нажмите для выбора нового файла',
            remove: 'УДАЛИТЬ',
            error: 'Ошибка'
        }
    });

    var drEvent = $('#input-file-events').dropify();
    drEvent.on('dropify.beforeClear', function (event, element) {
        return confirm("Вы уверены что хотите удалить  \"" + element.file.name + "\" ?");
    });
    drEvent.on('dropify.afterClear', function (event, element) {
        alert('Файл удален!');
    });
    drEvent.on('dropify.errors', function (event, element) {
        console.log('Has Errors');
    });
    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function (e) {
        e.preventDefault();
        if (drDestroy.isDropified()) {
            drDestroy.destroy();
        } else {
            drDestroy.init();
        }
    });


});