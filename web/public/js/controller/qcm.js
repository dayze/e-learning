var controllerQcm = function () {
    this.Dayze = new Dayze();
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
                if (resp.action == "new") {
                    /*    $("#course-table").find("tr:last").after(resp.data);
                     $("#course-table").find("tr:last").hide().fadeIn(400);*/
                }
                else if (resp.action == "edit") {
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
    var that = this;
    $('body').on('click', '#qcm-add-modal', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_create_qcm")
        })
            .done(function (resp) {
                $("#crudModal").replaceWith(resp.form);
                that.Dayze.newModalFeatures();
                that.initCollection();
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
                that.Dayze.newModalFeatures();
                that.initCollection();
                $("#crudModal").modal();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseJSON.error);
            });
    })

};

/*************************************OTHERS**************************************************/

controllerQcm.prototype.initCollection = function () {
    $('.parent-collection').collection({
        min: 1,
        add: '<a href="#" class="btn btn-info add-qcm"><span class="fa fa-plus-circle fa-lg"></span></a>',
        remove: '<a href="#" class="btn btn-danger"><span class="fa fa-remove fa-lg"></span></a>',
        allow_up:false,
        allow_down:false,
        prefix: 'parent',
        children: [{
            min: 1,
            selector: '.child-collection',
            remove: '<a href="#" class="btn btn-danger btn-xs btn-group">Supprimer une réponse</a>',
            add: '<a href="#" class="btn btn-info btn-xs btn-group">Ajouter une réponse</a>',
            allow_up:false,
            allow_down:false,
        }]
    });
    console.log($('.qcm-questions'));
};


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