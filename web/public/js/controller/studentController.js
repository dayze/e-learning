var studentController = function () {

};


studentController.prototype.init = function () { // only for document
    $('body').on('click', '.event-listener', function (e) {
        e.preventDefault();
        var data = {"act": $(this).attr('data-name')};
        var link = $(this).attr('data-href');
        var windowOpen = window.open(link, '_blank');
        $.ajax({
            type: "POST",
            url: Routing.generate("student_set_act"),
            data: data
        })
            .done(function (resp) {
                console.log('ok');
                windowOpen;
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (typeof jqXHR.responseJSON !== 'undefined') {

                } else {
                    alert(errorThrown);
                }
            });
    });
};

$(function () {
    var controller = new studentController();
    controller.init();
});