var controllerDocument = function () {
};

/*************************************CRUD**************************************************/
controllerDocument.prototype.addEditProcessing = function () {
    var that = this;
    $('body').on('submit', '.ajaxForm', function (e) {
        e.preventDefault();
        console.log(new FormData($(this)[0]));
        $.ajax({
            type: "post",
            contentType: false,
            processData: false,
            cache: false,
            url: $(this).attr('action'),
            data: new FormData($(this)[0])
        })
            .done(function (resp) {
                $("#crudModal").modal("hide");
                if (resp.action == "new") {
                    $("#document-table").find("tr:last").after(resp.data);
                    $("#document-table").find("tr:last").hide().fadeIn(400);
                }
                else if (resp.action == "edit") {
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

controllerDocument.prototype.deleteProcess = function () {
    var that = this;
    $('body').on('click', '.ajaxDelete', function (e) {
        e.preventDefault();
        that.sectionRawElement = $(this).parents('tr');
        $.ajax({
            type: "GET",
            url: Routing.generate("app_document_delete", {"id": $(this).attr('data-id')})
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

controllerDocument.prototype.newDisplay = function () {
    var that = this;
    $('body').on('click', '#document-add-modal', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_document_create")
        })
            .done(function (resp) {
                $("#crudModal").replaceWith(resp.form);
                $("#crudModal").modal();
                that.initCollection();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                console.log(jqXHR.responseJSON.error);
            });
    })

};

controllerDocument.prototype.editDisplay = function () {
    var that = this;
    $('body').on('click', '.ajaxEdit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_document_edit", {"id": $(this).attr('data-id')})
        })
            .done(function (resp) {
                $("#crudModal").replaceWith(resp.form);
                $("#crudModal").modal();
                that.initCollection();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseJSON.error);
            });
    })

};


/*************************************OTHERS**************************************************/

controllerDocument.prototype.coursesFromSection = function () {
    var that = this;
    var $sections = $('.section-input');
    $sections.change(function () {
        var data = {};
        data['section_id'] = $(this).val();
        var $course = $(this).parent().next().children('.course-input');
        $.ajax({
            url: Routing.generate("app_document_populate_course"),
            type: "POST",
            data: data
        })
            .done(function (resp) {
                $course.html('');
                $.each(resp, function (k, v) {
                    $course.append('<option value="' + v + '">' + k + '</option>');
                })
            });
    });
}

controllerDocument.prototype.courseCategoryFromCourse = function () {
    var that = this;
    var $course = $('.course-input');
    $course.change(function () {
        var data = {};
        data['courseCategory_id'] = $(this).val();
        var $courseCategory = $(this).parent().next().children('.courseCategory-input');
        $.ajax({
            url: Routing.generate("app_document_populate_courseCategory"),
            type: "POST",
            data: data
        })
            .done(function (resp) {
                $courseCategory.html('');
                $.each(resp, function (k, v) {
                    $courseCategory.append('<option value="' + v + '">' + k + '</option>');
                })
            });
    });

    //var $form = $(this).closest('form');
    //var data = {};
    //data["section_id"] = $(this).val();
    /*
     $.ajax({
     url: Routing.generate("app_document_populate_course"),
     type: "POST",
     data: data
     })
     .done(function (resp) {
     $('#appbundle_document_course').html('');
     $.each(resp, function (k, v) {
     $('#appbundle_document_course').append('<option value="' + v + '">' + k + '</option>');
     })
     });
     */


};

controllerDocument.prototype.initCollection = function () {
    var that = this;
    $('.section-collection').collection({
        after_add: function (collection, element) {
            that.coursesFromSection();
            that.courseCategoryFromCourse();
        }
    });
};

controllerDocument.prototype.init = function () {
    this.addEditProcessing();
    this.deleteProcess();
    this.newDisplay();
    this.editDisplay();
    this.coursesFromSection();
};

$(function () {
    var controller = new controllerDocument();
    controller.init();
});