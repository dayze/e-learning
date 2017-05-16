var dynamicSection = function () {

};

dynamicSection.prototype.loadCourse = function ($collection) {
    var that = this;
    $('body').on('change', '.section-input', function () {
        console.log('change section input');
        var $course = $(this).parent().next().children('.course-input');
        var $parentDiv = $(this).parent();
        var $form = $(this).closest('form');
        // Simulate form data, but only include the selected value.
        var data = {};
        data[$(this).attr('name')] = $(this).val();
        // Submit data via AJAX to the form's action path.
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: data,
            success: function (resp) {
                $course.replaceWith(
                    $(resp.form).find('.course-input')
                );
                that.emptyCollection($parentDiv);
                that.loadCourseCategories();

            }
        });

    });
};

dynamicSection.prototype.loadCourseCategories = function () {
    $('body').on('change', '.course-input', function () {
        var $courseCategory = $(this).parent().nextAll().children('.courseCategory-input');
        var $form = $(this).closest('form');
        // Simulate form data, but only include the selected value.
        var data = {};
        data[$(this).attr('name')] = $(this).val();
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: data,
            success: function (resp) {
                $courseCategory.replaceWith(
                    $(resp.form).find('.courseCategory-input')
                );
            }
        });

    });
};

dynamicSection.prototype.emptyCollection = function ($parentDiv) {
    var $courseCategory = $parentDiv.parent().children().last().children('select');
    $courseCategory.html('');
    $courseCategory.append('<option value selected="selected">-- Choisir --</option>');
};

dynamicSection.prototype.initCollection = function () {
    var that = this;
    that.loadCourse();
    $('.section-collection').collection({
        min: 1,
        after_add: function (collection, element) {
            //that.loadCourse(collection);
        }
    });
};

dynamicSection.prototype.init = function () {
    this.initCollection();
};

$(function () {
    var controller = new dynamicSection();
    controller.init();
});
