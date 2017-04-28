var global = function () {
    this.test = "Test of JS Controller"
};

global.prototype.testJS = function () {
    console.log(this.test);
};

global.prototype.cleanModal = function (modal) {
    modal.on('hidden.bs.modal', function(e)
    {
        $(this).find('input').not(':last').val("");
    });
};


global.prototype.init = function () {

};

$(function () {
    var controller = new global();
    controller.init();
});