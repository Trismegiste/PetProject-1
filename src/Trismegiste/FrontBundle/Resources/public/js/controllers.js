var combatApp = angular.module('combatApp', []);

combatApp.controller('MainCtrl', function($scope) {
    var characters = [
        {name: 'Spock', earth: 2, init: 5},
        {name: 'Kirk', earth: 5, init: 13},
        {name: 'Scotty', earth: 3, init: 8},
        {name: 'McCoy', earth: 4, init: 4}
    ];

    $scope.characters = characters;
    $scope.currentTurn = 100; // max init
    $scope.currentRound = 0;

    $scope.select = function(name) {
        console.log(name);
        characters.forEach(function(item) {
            if (item.name === name) {
                $scope.selected_char = item;
            }
        });
    };

    $scope.addCharacter = function() {
        $scope.characters.push({name: 'new_char', init: 0});
    };

    $scope.getWoundMalus = function(perso) {
        if (perso !== 'undefined') {
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
        if (perso !== 'undefined') {
            return perso.earth * (5 + 7 * 2);
        }
    };

});


