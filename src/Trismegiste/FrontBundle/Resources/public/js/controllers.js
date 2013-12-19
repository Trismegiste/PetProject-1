var combatApp = angular.module('combatApp', []);

combatApp.controller('MainCtrl', function($scope, $http) {
    var characters = [
        {name: 'Spock', earth: 2, init: 5},
        {name: 'Kirk', earth: 5, init: 13},
        {name: 'Scotty', earth: 3, init: 8},
        {name: 'McCoy', earth: 4, init: 4}
    ];

    $scope.characters = characters;
    $scope.currentInit = 100; // max init
    $scope.currentRound = 1;

    $http.get('/bundles/trismegistefront/js/combat/character_template.json').success(function(data) {
        $scope.template = data;
    });

    $scope.select = function(name) {
        characters.forEach(function(item) {
            if (item.name === name) {
                $scope.selected_char = item;
            }
        });
    };

    $scope.addCharacter = function(name) {
        $scope.template.forEach(function(item) {
            if (item.name === name) {
                $scope.characters.push(angular.copy(item));
            }
        });
    };

    $scope.getWoundMalus = function(perso) {
        if (perso !== undefined) {
            var idxMalus = perso.wound / perso.earth;
            var woundedMalus = [3, 5, 10, 15, 20, 40, 'out', 'dead'];

            if (idxMalus <= 5) {
                return 0;
            } else {
                var rank = Math.ceil((idxMalus - 5) / 2) - 1;
                return woundedMalus[rank];
            }
        }
    };

    $scope.getHP = function(perso) {
        if (perso !== undefined) {
            return perso.earth * (5 + 7 * 2);
        }
    };

    $scope.getHilite = function(stat) {
        return (stat === $scope.currentInit) ? "current-turn" : '';
    };

    $scope.goToNextTurn = function() {
        var newInit = 0;
        characters.forEach(function(item) {
            if (item.init < $scope.currentInit) {
                if (item.init > newInit) {
                    newInit = item.init;
                }
            }
        })
        $scope.currentInit = newInit;
    };

    $scope.goToNextRound = function() {
        if ($scope.currentInit === 0) {
            $scope.currentRound++;
            $scope.currentInit = 100;
            $scope.goToNextTurn();
        }
    };

    $scope.isSelected = function(name) {
        return (name === $scope.selected_char.name) ? "selected-character" : '';
    };

});


