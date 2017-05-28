var controllerSection = function () {
    this.sectionRawElement = "";
    $('#section').addClass('active');
    this.sectionId = "";
};

/*************************************CRUD**************************************************/
controllerSection.prototype.addEditFormSection = function () {
    var that = this;
    $('body').on('submit', '.ajaxForm', function (e) {
        e.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize()
        })
            .done(function (resp) {
                $("#addSectionModal").modal("hide");
                if (resp.action == "new") {
                    $("#section-table").find("tr:last").after(resp.data);
                    $("#section-table").find("tr:last").hide().fadeIn(400);
                }
                else if (resp.action == "edit") {
                    $(".ajaxEdit[data-id=" + resp.id + "]").parents('tr').replaceWith(resp.data);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseJSON);
                if (typeof jqXHR.responseJSON !== 'undefined') {
                    if (jqXHR.responseJSON.hasOwnProperty('form')) {
                        $("#addSectionModal").replaceWith(jqXHR.responseJSON.form);
                        $('.modal-backdrop').remove();
                        $("#addSectionModal").modal('show');
                    }
                } else {
                    alert(errorThrown);
                }
            });
    })
};

controllerSection.prototype.deleteSection = function () {
    var that = this;
    $('body').on('click', '.ajaxDelete', function (e) {
        e.preventDefault();
        that.sectionRawElement = $(this).parents('tr');
        $.ajax({
            type: "GET",
            url: Routing.generate("app_deleteSection", {"id": $(this).attr('data-id')})
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

controllerSection.prototype.newDisplaySection = function () {
    $('body').on('click', '#section-add-modal', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_createSection")
        })
            .done(function (resp) {
                $("#addSectionModal").replaceWith(resp.form);
                $("#addSectionModal").modal();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseJSON.error);
            });
    })

};

controllerSection.prototype.editDisplaySection = function () {
    var that = this;
    $('body').on('click', '.ajaxEdit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: Routing.generate("app_editSection", {"id": $(this).attr('data-id')})
        })
            .done(function (resp) {
                $("#addSectionModal").replaceWith(resp.form);
                $("#addSectionModal").modal();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseJSON.error);
            });
    })

};

controllerSection.prototype.displayPdfDate = function () {
    var that = this;
    $('body').on('click', '.display-pdf', function (e) {
        var data = {};
        data["section_id"] = $(this).attr('data-id');
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: Routing.generate("app_display_pdf_date"),
            data: data
        })
            .done(function (resp) {
                $("#pdfModal").replaceWith(resp.form);
                $("#pdfModal").modal();
                that.initDateTimePicker();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseJSON.message);
            });
    })

};

/*************************************OTHERS**************************************************/
controllerSection.prototype.initDateTimePicker = function () {
    $('.js-datepicker').datepicker.dates['fr'] = {
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jui", "Aoû", "Sep", "Oct", "Nov", "Déc"],
    }
    $('.js-datepicker').datepicker({
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        language: 'fr'
    });

};

controllerSection.prototype.onError = function () {
    if($('#onError').attr('data-error') == true){
        alert("Aucun élève de cette section n'a rattrapé de temps");
    }
};

controllerSection.prototype.init = function () {
    this.addEditFormSection();
    this.deleteSection();
    this.editDisplaySection();
    this.newDisplaySection();
    this.displayPdfDate();
    this.onError();
};

$(function () {
    var controller = new controllerSection();
    controller.init();
});