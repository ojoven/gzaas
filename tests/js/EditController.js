describe("EditController", function () {
    beforeEach(module('gzaas'));

    var ctrl, scope;

    beforeEach(inject(function ($controller, $rootScope) {
        scope = $rootScope.$new();
        ctrl = $controller('EditController', {
            $scope: scope
        });
    }));

    it('should exists conf', inject(function () {
        expect(scope.gzaas).toBeDefined();
    }));

});