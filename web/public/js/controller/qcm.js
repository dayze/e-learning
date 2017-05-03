var controllerQcm = function () {

};

/*************************************CRUD**************************************************/
controllerQcm.prototype.addEditProcessing = function () {
    var that = this;
    $('body').on('submit', '.ajaxForm', function (e) {
        e.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize()
        })
            .done(function (resp) {
                $("#crudModal").modal("hide");
                if(resp.action == "new"){
                /*    $("#course-table").find("tr:last").after(resp.data);
                    $("#course-table").find("tr:last").hide().fadeIn(400);*/
                }
                else if(resp.action == "edit"){
                    $(".ajaxEdit[data-id=" + resp.id + "]").parents('tr').replaceWith(resp.data);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')) {
                        $("#crudModal").replaceWith(jqXHR.responseJSON.form);
                        $('.modal-backdrop').remove();
                        $("#crudModal").modal('show');
                    }
                } else {
                    alert(errorThrown);
                }
            });
    })
};

controllerQcm.prototype.deleteProcess = function () {
    var that = this;
    $('body').on('click', '.ajaxDelete', function (e) {
        e.preventDefault();
        that.sectionRawElement = $(this).parents('tr');
        $.ajax({
            type: "GET",
            url: Routing.generate("app_delete_qcm", {"id": $(this).attr('data-id')})
        })
            .done(function (resp) {
                that.sectionRawElement.fadeOut(400, function () {
                    that.sectionRawElement.remove();
                });
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseJSON.error);
                if (jqXHR.responseJSON.error == true) {
                    alert("Une erreur s'est produite");
                } else {
                    alert(errorThrown);
                }
            });
    })

};

controllerQcm.prototype.newDisplay = function () {
    $('body').on('click', '#qcm-add-modal', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_create_qcm")
        })
            .done(function (resp) {
                $("#crudModal").replaceWith(resp.form);
                $("#crudModal").modal();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                console.log(jqXHR.responseJSON.error);
            });
    })

};

controllerQcm.prototype.editDisplay = function () {
    var that = this;
    $('body').on('click', '.ajaxEdit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_edit_qcm", {"id": $(this).attr('data-id')})
        })
            .done(function (resp) {
                $("#crudModal").replaceWith(resp.form);
                $("#crudModal").modal();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseJSON.error);
            });
    })

};

/*************************************OTHERS**************************************************/


controllerQcm.prototype.init = function () {
    this.addEditProcessing();
    this.deleteProcess();
    this.newDisplay();
    this.editDisplay();
};

$(function () {
    var controller = new controllerQcm();
    controller.init();
});