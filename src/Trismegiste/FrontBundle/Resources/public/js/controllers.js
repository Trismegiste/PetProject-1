var combatApp = angular.module('combatApp', []);

combatApp.controller('MainCtrl', function($scope) {
    var characters = [
        {name: 'Spock', HP: 45, init: 5},
        {name: 'Kirk', HP: 130, init: 13},
        {name: 'Scotty', HP: 60, init: 8},
        {name: 'McCoy', HP: 80, init: 4}
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
        $scope.characters.push({name: 'new_char', init:0});
    };

});


