$('#button_comment').click(function() {

    $this = $(this);
    if(!$this.hasClass('isVisible'))
    {
        $this.toggleClass('isVisible');
        $('#num1').css('display','none');
        $("#block").fadeIn(500);
        $this.html('СМОТРЕТЬ МЕНЬШЕ КОММЕНТАРИЕВ');
    }
    else
    {
        $this.toggleClass('isVisible');
        $('#num1').css('display','block');
        $("#block").fadeOut(500);
        $this.html('СМОТРЕТЬ ВСЕ КОММЕНТАРИИ');
    }
});

$('.change_user').click(function() {
    $( "#form-user" ).submit();
});

$('.change_profile').click(function() {
    $( "#form-profile" ).submit();
});

$('.change_user_profile').click(function() {
    $( "#form-user-profile" ).submit();
});

$('.new_user').click(function() {
    $( "#form-user-new" ).submit();
});

$('.admin_change_post').click(function() {
    $( "#admin_change_post_form" ).submit();
});

$('.admin_new_category').click(function() {
    $( "#admin_change_category_form" ).submit();
});

$('.admin_change_category').click(function() {
    $( "#admin_change_category_form" ).submit();
});

$(".select_comment_approved").change(function() {
    var obj = this;
    var id_num = $(obj).data("post-id");
    var url = $(obj).data("url");
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    //console.log(csrfToken);
    $.ajax({
        type:"POST",
        url:url,
        data:{_token: csrfToken,postid: id_num},
        success: function () {
            //alert($(obj).val());
            if($(obj).val() == 1) {
                $(obj).css('color','lightgreen');
            }
            else{
                $(obj).css('color','#FFA9AE');
            }

            console.log(url);
        },
        error: function(){
            console.log('error');
        }
    });
});

$(".select_post_approved").change(function() {
    var obj = this;
    var id_num = $(obj).data("post-id");
    var url = $(obj).data("url");
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    //console.log(csrfToken);
    $.ajax({
        type:"POST",
        url:url,
        data:{_token: csrfToken,postid: id_num},
        success: function () {
            //alert($(obj).val());
            if($(obj).val() == 1) {
                $(obj).css('color','lightgreen');
            }
            else{
                $(obj).css('color','#FFA9AE');
            }

            console.log(url);
        },
        error: function(){
            console.log('error');
        }
    });
});

function deleteCategory(obj) {
    var url_check = $(obj).data("url-check");
    var url_change = $(obj).data("url-change");
    var id_num = $(obj).data("post-id");
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log(csrfToken);

    var flag = confirm("Удалить эту запись?");
    if (flag) {
        var ajaxCall =  $.ajax({
            type:"POST",
            url:url_check,
            data:{_token: csrfToken, postid: id_num},
            success: function () {
            },
            error: function(){
            }
        });

        ajaxCall.done(function (data) {
            if(data == 1){
                alert('Категория не удалена. Категория содержит статьи.');
            }
            else{
                $.ajax({
                    type:"POST",
                    url:url_change,
                    data:{_token: csrfToken, postid: id_num}
                });
                $(obj).closest("tr").fadeOut(500);
            }
        });
    }
}

function deleteConfirmUser(obj) {
    var url_check = $(obj).data("url-check");
    var url_change = $(obj).data("url-change");
    var id_num = $(obj).data("post-id");
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log(csrfToken);

    var flag = confirm("Удалить эту запись?");
    if (flag) {
        var ajaxCall =  $.ajax({
            type:"POST",
            url:url_check,
            data:{_token: csrfToken, postid: id_num},
            success: function () {
            },
            error: function(){
            }
        });

        ajaxCall.done(function (data) {
            if(data == 1){
                alert('Пользователь не удален. За пользователем есть закрепленные статьи.');
            }
            else{
                $.ajax({
                    type:"POST",
                    url:url_change,
                    data:{_token: csrfToken, postid: id_num}
                });
                $(obj).closest("tr").fadeOut(500);
            }
        });
    }
}

function deleteConfirm(obj) {
    var url = $(obj).data("url");
    var id_num = $(obj).data("post-id");
    var flag = confirm("Удалить эту запись?");
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log(csrfToken);

    if (flag) {
        $.ajax({
            type:"POST",
            url:url,
            data:{_token: csrfToken,postid: id_num},
            success: function () {
                $(obj).closest("tr").fadeOut(500);
            },
            error: function(){
            }
        });
    }
}

function like_ajax(obj) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var o = obj;
    var num = $(obj).find('span');

    $.ajax({
        url: $(o).data('url'),
        type: "GET",
        data: {
            _token: CSRF_TOKEN,
        },
        dataType: "html",
        success: function () {
            if ( $(o).hasClass('has-like') ) {
                console.log('yes class');

                $(num).text( parseInt($(num).text()) - 1 );

            } else {
                console.log('no class');

                $(num).text( parseInt($(num).text()) + 1 );

            }

            $(o).toggleClass('has-like');

            console.log("Like");

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log("Ошибка!", "Произошла ошибка", "error");
        }
    });
}

$(document).ready(function(){

    $(document).on('click','#btn-more',function(){
        var sumpostsout = $(this).data('sumpostsout');
        var url = $(this).data('url');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $("#btn-more").html("Loading....");
        $.ajax({
            type:"POST",
            url:url,
            data:{
                _token: csrfToken,
                sumpostsout: sumpostsout
            },
            success : function (data)
            {
                if(data != '')
                {
                    $('#remove-row').remove();
                    $('#load-data').append(data);
                }
            },
            error: function(){
                console.log('error');
            }
        });
    });
});
