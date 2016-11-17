<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/materialize.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

  </head>
  <body ng-app="myApp">
    <div class="main-container">
      <div class="controller" ng-controller="mainController">
        <input type="text" ng-model="search" class="table-search form-control" placeholder="Search product..." />
        <table>
          <thead><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th></th><th></th></thead>
          <tbody>
            <tr ng-repeat="name in names | filter:search"><td>{{ name.id }}</td><td>{{ name.name }}</td><td>{{ name.description }}</td><td>${{ name.price }}</td><td class="edit-button"><a href="#edit" ng-click="readOne(name.id)">Edit</a></td><td class="delete-button"><a href="#delete" ng-click="deleteProduct(name.id)">Delete</a></td></tr>
          </tbody>
        </table>
        <div class="form-container">
          <div><strong>Name: </strong><input ng-model="name" type="text"></div>
          <div><strong>Description: </strong><textarea ng-model="description"></textarea></div>
          <div><strong>Price: </strong><input ng-model="price" type="text"></div>
          <a class="submit-button" ng-click="editProduct()">Submit</a>
        </div> 
        <div class="fixed-action-btn" style="bottom:45px; right:24px;">
          <a class="waves-effect waves-light btn modal-trigger btn-floating btn-large red" href="#modal-product-form">
            <i class="large material-icons" style="background: #BA2B20;">add</i>
          </a>
        </div>
      </div> 
    </div>
  </body>
  <script src="js/jquery-1.9.1.min.js"></script> 
  <script src="https://code.angularjs.org/1.5.8/angular.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script>
    var myApp = angular.module('myApp', []);
        
    myApp.controller('mainController', function ($scope, $http) {
                  
      $scope.deleteProduct = function(id) {
        $http.post("delete_product.php", { 'id' : id }).success(function(response){
          console.log(response.records);
        });
      }
      
      $scope.getProfile = function () {
        $http.get('https://teamtreehouse.com/chalkers.json').success(function(response){
          console.log(response);
        });
      }
      
      $scope.getProfile();
      
      $http.get("read_all.php").success(function(response){
          $scope.names = response.records;
      });
      
      $scope.readOne = function(id) {
        $http.post("read_one.php", { 'id' : id }).success(function(response) {
          $scope.name = response[0].name;
          $scope.description = response[0].description;
          $scope.price = response[0].price;
          //console.log(response);
        });
      }
      
      $scope.editProduct = function () {
        $http.post("create_product.php", {'name' : $scope.name, 'description' : $scope.description, 'price' : $scope.price }).success(function(response){
          console.log(response);
        });
      }
      
    });
    
    //here is a comment
    
  </script>
</html>