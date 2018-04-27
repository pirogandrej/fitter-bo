$(document).ready(function () {

});


!function($) {

    "use strict";

    var SweetAlert = function() {};

    //examples
    SweetAlert.prototype.init = function() {

        //Warning Message
        $('.delete-direction').click(function(){

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var id = $(this).data('direction-id'),
                row = $(this).closest('tr'),
                name = $(this).data('name'),
                url = $(this).data('url');

            swal({
                title: "Вы уверены?",
                text: "Вы собираетесь удалить направление " + name + "?",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Отмена",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, удалить",
                closeOnConfirm: false
            }, function(){
                swal("Удален!", "Вы удалили направление " + name + ".", "success");
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: CSRF_TOKEN,
                        id: id
                    },
                    dataType: "html",
                    success: function () {
                        $(row).fadeOut('slow');
                        swal("Готово!", "Направление " + name + " удалено успешно!", "success");
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("Ошибка!", "Произошла ошибка удаления", "error");
                    }
                });
            });
        });

    },
        //init
        $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing
    function($) {
        "use strict";
        $.SweetAlert.init()
    }(window.jQuery);