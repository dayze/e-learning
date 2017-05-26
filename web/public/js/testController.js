var testController = function () {

};


testController.prototype.testFunction = function () {
    console.log('hello wolrd');
};

testController.prototype.init = function () {
    this.testFunction();
};

$(function () {
    var controller = new testController();
    controller.init();
});