<nav class="navbar navbar-inverse ">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Dictionary <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-search"></i></div>
                <input type="text" class="form-control" placeholder="Search word" ng-change="changeSearch()" ng-model="searchWord">
              </div>      
            </div>
      </form>
    </div>
  </div>
</nav>