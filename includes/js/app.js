var app = angular.module('dictionary', []);

app.controller('wordsControler', ['$scope', '$http', function ($scope, $http){
	this.newWord = {};

	$scope.sortType     = 'text'; // set the default sort type
  	$scope.sortReverse  = false;  // set the default sort order
  	$scope.searchFish   = '';     // set the default search/filter term
    
    $scope.token = getCookie("xUt");
  	
    $scope.limitSize   = 10;
  	$scope.limitBegin  =  0;
    $scope.searchFirst = true;
    $scope.currentPage = 1;

	$http.post('../rest/read_words.php', {'token': $scope.token} ).success(function(data) {
        $scope.words = data.records;
    });

    $scope.changeSearch = function() {

        if($scope.searchFirst == true){
            $scope.old_limitBegin = $scope.limitBegin;
            $scope.old_limitSize  = $scope.limitSize;
            $scope.searchFirst    = false;
        }

        if($scope.searchWord.length > 0){
            $scope.limitBegin = 0;
            $scope.limitSize  = $scope.words.length;
            $('.pagination').hide();
        }else{
            $scope.limitBegin  = $scope.old_limitBegin;
            $scope.limitSize   = $scope.old_limitSize;
            $scope.searchFirst = true;
            $('.pagination').show();
        }
    }

	$scope.save = function() {
		$scope.errors   = [];
        $scope.warnings = [];

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

        
        $http.post('../rest/save_word.php', {'text': $scope.text, 'description': $scope.description, 'language_id': 1, 'token': $scope.token}
        ).success(function(data, status, headers, config) {
            if (data.msg != ''){
                $scope.words.push(data);
                $scope.text = '';
                $scope.description = '';
                $('#input_new_word').focus();
                $('#del_').attr('id', 'del_'+data.id);
                // $('#edit_').attr('id', 'edit_'+data.id);
                //updatePagination($scope.token);
            }else{
                if(data.warning != ''){
                    $scope.warnings.push(data.warning);
                    $scope.searchWord = $scope.text;
                }else{
                    $scope.errors.push(data.error);    
                }
                
            }
        }).error(function(data, status) {
            $scope.errors.push(status);
        });
    }

    $scope.clearAll = function(){
        $scope.text = '';
        $scope.description = '';
        $scope.searchWord = '';
    }

    $scope.removeWord = function(word_id){
        var n = $scope.words.length;
        for(i = 0; i < n; i++){
            if($scope.words[i]["id"] == word_id){
                $scope.words.splice(i, 1);
                break;
            }
        }
    }

    $scope.delete = function(word_id) {
        $scope.errors = [];
        error = false;
        var r = confirm('Are you sure you want to delete this word?');
        if(r == true){
            $http.post('../rest/delete_word.php', {'word_id': word_id, 'token': $scope.token}
            ).success(function(data, status, headers, config) {
                if (data.msg != ''){
                    $scope.removeWord(word_id);
                    //updatePagination($scope.token);
                }else{
                    $scope.errors.push(data.error);
                }
            }).error(function(data, status) {
                $scope.errors.push(status);
            });
        }
    }

    $scope.page = function(page_number){
        $('ul.pagination li.active').removeClass('active');
        $('#li_'+page_number).addClass('active');
    	$scope.limitBegin = (page_number-1)*$scope.limitSize;
        $scope.currentPage = page_number;

        // show only 10 pages at time
        var number_of_pages = 10;
        var pages_before = (number_of_pages / 2) -1; // 4
        var pages_after  = ( number_of_pages / 2 );  // 5

        var min_page = page_number - pages_before;
        var max_page = page_number + pages_after;

        var min_fix = 0;
        var max_fix = 0;

        var lastPage  =  $('.pagination li').eq(-2).attr('id').substr(3);
        var firstPage = 1; 

        if(min_page < firstPage){
            min_fix  = min_page - (min_page*2) + 1; // convert to positive and add one (because the index 0)
            min_page = firstPage;
        }

        if(max_page > lastPage){
            max_fix = max_page - lastPage;
            max_page = lastPage;
        }

        for(i = firstPage; i <= lastPage; i++ ){
            var element = $('#li_'+i);

            if( (i >= (min_page-max_fix) ) && ( i <= (max_page + min_fix) ) ){
                element.show();
            }else{
                element.hide();
            }
        }
    }

    $scope.next_page = function(){
        if($scope.currentPage != $('.pagination li').eq(-2).attr('id').substr(3) ){
            $scope.page(++$scope.currentPage);
        }
    }

    $scope.previous_page = function(){
        if($scope.currentPage > 1 ){
            $scope.page(--$scope.currentPage);
        }
    }

}]);

/*
function updatePagination(token){

   $.ajax({
     type: "POST",
     url: '../rest/update_pagination.php',
     data: {'token': token},
     success: function(data) {
        $('#div_pagination').html(data);
     }

   });
}
*/

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}