var controllerSupervisor = function () {
    this.userType = $('#userType').attr('data-userType');
};

/*************************************CRUD**************************************************/
controllerSupervisor.prototype.addEditProcessing = function () {
    var that = this;
    $('body').on('submit', '.ajaxForm', function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        formData.push({name: "userType", value:that.userType});
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData
        })
            .done(function (resp) {
                $("#crudModal").modal("hide");
                if(resp.action == "new"){
                    $("#user-table").find("tr:last").after(resp.data);
                    $("#user-table").find("tr:last").hide().fadeIn(400);
                }
                else if(resp.action == "edit"){
                    $(".ajaxEdit[data-id=" + resp.id + "]").parents('tr').replaceWith(resp.data);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseJSON);
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

controllerSupervisor.prototype.deleteProcess = function () {
    var that = this;
    $('body').on('click', '.ajaxDelete', function (e) {
        e.preventDefault();
        that.sectionRawElement = $(this).parents('tr');
        $.ajax({
            type: "GET",
            url: Routing.generate("app_user_delete", {"id": $(this).attr('data-id')})
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

controllerSupervisor.prototype.newDisplay = function () {
    $('body').on('click', '#user-add-modal', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_user_create")
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

controllerSupervisor.prototype.editDisplay = function () {
    var that = this;
    $('body').on('click', '.ajaxEdit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_user_edit", {"id": $(this).attr('data-id')})
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


controllerSupervisor.prototype.init = function () {
    this.addEditProcessing();
    this.deleteProcess();
    this.newDisplay();
    this.editDisplay();
};

$(function () {
    var controller = new controllerSupervisor();
    controller.init();
});