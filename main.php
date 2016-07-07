<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<!doctype html>
<html lang="en" ng-app="dictionary">
<head>
  	<meta charset="utf-8">

  	<title>My Dictionary</title>
  	<meta name="description" content="My Dictionary">
  	<meta name="author" content="Rafael Simonassi">

  	<link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/4.1.1/normalize.css">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="includes/css/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
  	
</head>

<body>

	<div class="container" ng-controller = "wordsControler as wDictionary">
		<?php require_once('includes/nav_bar.php'); ?>
		<div class="row">
  			  		
  			<div class="col-md-3 ">
  					<input type="text" class="form-control" placeholder="New word" ng-model="text" >
			</div>
  			<div class="col-md-8 col-md-offset-1">
  				<div class="input-group">
  					<input type="hidden" name="dictionary_id" id="dictionary_id" value="1">
	  				<input type="text" class="form-control" placeholder="Description" ng-model="description">
	      			<span class="input-group-btn">
	        			<button class="btn btn-default" type="button" ng-click="save()">Save Word</button>
	      			</span>
	      		</div>
  			</div>	
  		</div>
  		<br>
  		<div class="row">
  			<div class="col-md-12">
  				<div class="alert alert-danger" role="alert" ng-repeat="error in errors">{{ error }}</div>
  				<div class="panel panel-default">
  					
	  				<table class="table"> 
	  					<thead> 
	  						<tr class="title"> 
	  							<th>
	  								<a href="#" ng-click="sortType = 'text'; sortReverse = !sortReverse">Word</a>
	  								<span ng-show="sortType == 'text' && !sortReverse" class="fa fa-caret-down"></span>
        							<span ng-show="sortType == 'text' && sortReverse"  class="fa fa-caret-up"></span>
        						</th> 
	  							<th>
	  								<a href="#" ng-click="sortType = 'description'; sortReverse = !sortReverse">Description</a>
	  								<span ng-show="sortType == 'description' && !sortReverse" class="fa fa-caret-down"></span>
        							<span ng-show="sortType == 'description' && sortReverse"  class="fa fa-caret-up"></span>
	  							</th> 
	  						</tr> 
	  					</thead> 

	  					<tbody> 
	  						<tr ng-repeat="w in words | orderBy:sortType:sortReverse | filter:searchWord">
	  							<td>{{w.text}}</td> 
	  							<td>{{w.description}}</td> 
	  						</tr> 
	  					</tbody> 
	  				</table>
	  			</div>
  			</div>

  		</div>
	</div>
	<span>
</span>

	<script src="includes/js/angular.min.js"></script>
  	<script src="includes/js/app.js"></script>
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
</body>
</html>

<?php 
if (isset($connection)) {
  mysqli_close($connection);
}
?>