var studentController = function () {

};

studentController.prototype.gradeModal = function () {
    $('body').on('click', '.grade', function (e) {
        e.preventDefault();
        var data = {}
        data["qcm_id"] = $(this).parents('tr').attr('data-qcm-id');
        $.ajax({
            type: "POST",
            url: Routing.generate('student_display_grade'),
            data: data
        })
            .done(function (resp) {
                $('#gradeModal').replaceWith(resp);
                $('#gradeModal').modal();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert("Vous n'avez pas de note pour ce QCM");
            });
    });
};

studentController.prototype.setAct = function () {
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

}

studentController.prototype.init = function () { // only for document
    this.gradeModal();
    this.setAct();
};

$(function () {
    var controller = new studentController();
    controller.init();
});