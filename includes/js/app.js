var app = angular.module('dictionary', []);

app.controller('wordsControler', ['$scope', '$http', function ($scope, $http){
	this.newWord = {};

	$scope.sortType     = 'text'; // set the default sort type
  	$scope.sortReverse  = false;  // set the default sort order
  	$scope.searchFish   = '';     // set the default search/filter term

  	$scope.limitSize  = 10;
  	$scope.limitBegin =  0;

	$http.get('read_words.php').success(function(data) {
        $scope.words = data.records;
        //$scope.numberPages = Math.ceil($scope.words.length/$scope.limitSize);
    });
    

	$scope.save = function() {
		$scope.errors = [];
		error = false;

		if($scope.text == '' || $scope.text == null){
			error = "Insert a word.";
		}else if($scope.description == '' || $scope.description == null){
			error = "Insert a description.";
		}

		if(error){
			$scope.errors.push(error);
			return;
		}

        $http.post('save_word.php', {'text': $scope.text, 'description': $scope.description, 'language_id': 1}
        ).success(function(data, status, headers, config) {
            if (data.msg != ''){
                $scope.words.push(data);
                $scope.text = '';
                $scope.description = '';
                $('#input_new_word').focus();
            }else{
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) {
            $scope.errors.push(status);
        });
    }

    $scope.page = function(page_number){
    	$scope.limitBegin = (page_number-1)*$scope.limitSize;
    }
}]);