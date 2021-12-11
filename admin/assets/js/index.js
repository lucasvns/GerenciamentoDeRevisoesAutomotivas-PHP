angular.module("dragndropdemo", ['ngRepeatReorder']);

function dragndropdemo($scope) {
	$scope.names = [{val:'bob'},{val:'lucy'},{val:'john'},{val:'luke'},{val:'han'}];
	$scope.tempplayer = '';
	$scope.updateNames = function (){
		if($scope.tempplayer === "") //return
		$scope.names.push({val: $scope.tempplayer});
		$scope.tempplayer = "";
	};
	$scope.checkForNameDelete = function($index){
		if($scope.names[$index].val === ''){
			$scope.names.splice($index, 1);
		}
	};
};