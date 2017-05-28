var controllerCourseCategory = function () {
    this.rawElement = "";
    this.courseId = "";
};

/*************************************CRUD**************************************************/
controllerCourseCategory.prototype.addEditProcessing = function () {
    var that = this;
    $('body').on('submit', '.ajaxFormCategory', function (e) {
        e.preventDefault();

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize()
        })
            .done(function (resp) {
                $("#crudModal").modal("hide");
                if (resp.action == "new") {
                    var tr = $("tr[data-courseId-category='" + that.courseId + "']");
                    console.log();
                    if(tr.length != 0){
                        $(resp.data).insertAfter(tr.last());
                        if (tr.hasClass('in')) {
                            $("tr[data-courseId-category='" + that.courseId + "']").
                            addClass('in').css('display', 'true').attr('aria-expanded', 'true').
                            children().children().addClass('in');
                        }
                    }
                    else{
                        $(resp.data).insertAfter(that.rawElement.parents('tr'));
                        $("tr[data-courseId-category='" + that.courseId + "']").
                        addClass('in').css('display', 'true').attr('aria-expanded', 'true').
                        children().children().addClass('in')
                    }


                }
                else if (resp.action == "edit") {
                    $(".ajaxEditCategory[data-id=" + resp.id + "]").parents('tr').replaceWith(resp.data);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
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

controllerCourseCategory.prototype.deleteProcess = function () {
    var that = this;
    $('body').on('click', '.ajaxDeleteCategory', function (e) {
        e.preventDefault();
        that.sectionRawElement = $(this).parents('tr');
        $.ajax({
            type: "GET",
            url: Routing.generate("app_delete_courseCategory", {"id": $(this).attr('data-id')})
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

controllerCourseCategory.prototype.newDisplay = function () {
    var that = this;
    $('body').on('click', '#courseCategory-add-modal', function (e) {
        that.rawElement = $(this);
        that.courseId = $(this).parents('tr').attr('data-course-id');
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_create_courseCategory", {"id": that.rawElement.attr('data-id')})
        })
            .done(function (resp) {
                $("#crudModal").replaceWith(resp.form);
                $("#crudModal").modal();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {

            });
    })

};

controllerCourseCategory.prototype.editDisplay = function () {
    var that = this;
    $('body').on('click', '.ajaxEditCategory', function (e) {
        that.courseId = $(this).parents('tr').attr('data-course-id');
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_edit_courseCategory", {"id": $(this).attr('data-id')})
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


controllerCourseCategory.prototype.init = function () {
    this.addEditProcessing();
    this.deleteProcess();
    this.newDisplay();
    this.editDisplay();
};

$(function () {
    var controller = new controllerCourseCategory();
    controller.init();
});