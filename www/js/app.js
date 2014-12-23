(function () {
    'use strict';

    angular.module('gzaas', ['ui.bootstrap', 'ui.router'])

        .value('config', {
            apiUrl: '/api',

            font: ['font1', 'font2', 'font3'],
            texture: ['texture1', 'texture2', 'texture3'],

            fonts: {
                font1: {url: 'Pacifico', style: "font-family: 'Pacifico', cursive;"},
                font2: {url: 'Seaweed+Script', style: "font-family: 'Seaweed Script', cursive;"},
                font3: {url: 'Ruthie', style: "font-family: 'Ruthie', cursive;"}
            },

            textures: {
                texture1: {url: 'BackgroundLabs/polkadot2.gif'},
                texture2: {url: 'BackgroundLabs/blackboard.jpg'},
                texture3: {url: 'BackgroundLabs/hearts.gif'}
            }
        })

        .config(function ($stateProvider, $urlRouterProvider) {
            $urlRouterProvider.otherwise("/");
            $stateProvider
                .state('home', {
                    url: "/",
                    templateUrl: "partials/home.html",
                    controller: 'HomeController'
                })
                .state('view', {
                    url: "/:id",
                    templateUrl: "partials/view.html",
                    controller: 'ViewController'
                })
                .state('edit', {
                    url: "/edit/:text",
                    templateUrl: "partials/edit.html",
                    controller: 'EditController'
                });
        })

        .controller('HomeController', function ($scope, $state) {
            $scope.gazzear = function () {
                $state.go('edit', {text: $scope.text});
            };
        })

        .controller('ViewController', function ($http, $scope, $stateParams, Gzaas, config) {
            var id = $stateParams.id;

            $http.get(config.apiUrl + '/gzaas/' + id).success(function (data) {
                $scope.view = $scope.view = Gzaas.renderGzaas(data.font, data.texture);

                $scope.gzaas = {
                    text: data.text,
                    font: config.fonts[data.font],
                    texture: config.textures[data.texture]
                };
            });
        })

        .service('Gzaas', function (config) {
            return {
                renderGzaas: function (font, texture) {
                    var confFont = config.fonts[font],
                        confTexture = config.textures[texture];

                    return {
                        backgroundStyle: 'background-image: url(http://www.gzaas.com/images/patterns/' + confTexture.url + ');',
                        fontUrl: 'http://fonts.googleapis.com/css?family=' + confFont.url,
                        fontStyle: confFont.style
                    };
                }
            };
        })

        .controller('EditController', function ($scope, $stateParams, $http, $modal, $state, $timeout, Gzaas, config) {

            var renderGzass = function () {
                $scope.view = Gzaas.renderGzaas($scope.gzaas.font, $scope.gzaas.texture);
            };

            $scope.gzaas = {
                font: config.font[Math.floor((Math.random() * 3))],
                texture: config.texture[Math.floor((Math.random() * 3))],
                text: $stateParams.text
            };

            renderGzass();

            $scope.save = function () {
                $http.post(config.apiUrl + '/gzaas', {gzaas: $scope.gzaas}).success(function (data) {
                    $state.go('view', {id: data.id});
                });
            };

            $scope.openModal = function (type) {
                $scope.type = type;

                var modalInstance = $modal.open({
                    templateUrl: 'partials/modal.html',
                    controller: 'ModalController',
                    size: undefined,
                    scope: $scope
                });

                modalInstance.result.then(function () {
                    renderGzass();
                });
            };
        })

        .controller('ModalController', function ($scope, $modalInstance, $log, config) {
            $scope.items = config[$scope.type];

            $scope.ok = function (selected) {
                $scope.gzaas[$scope.type] = selected;
                $modalInstance.close();
            };

            $scope.cancel = function () {
                $modalInstance.dismiss('cancel');
            };
        })
    ;
}());