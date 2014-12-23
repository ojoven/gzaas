describe("HomeController", function () {
    beforeEach(module('gzaas'));

    var ctrl, scope;

    beforeEach(inject(function ($controller, $rootScope) {
        scope = $rootScope.$new();
        ctrl = $controller('HomeController', {
            $scope: scope
        });
    }));

    it('should exists gazzear', inject(function () {
        expect(scope.gazzear).toBeDefined();
    }));

});