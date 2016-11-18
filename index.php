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
    <title>Angular | CRUD</title>

  </head>
  <body ng-app="myApp">
    <div class="main-container">
      <h3 class="page-title">This is an Angular CRUD Application</h3>
      <div class="controller" ng-controller="mainController">
        <input type="text" ng-model="search" class="table-search form-control" placeholder="Search product..." />
        <table>
          <thead><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th></th><th></th></thead>
          <tbody>
            <tr ng-repeat="name in names | filter:search"><td>{{ name.id }}</td><td>{{ name.name }}</td><td>{{ name.description }}</td><td>${{ name.price }}</td><td class="edit-button"><a ng-click="readOne(name.id)">Edit</a></td><td class="delete-button"><a href="#delete" ng-click="deleteProduct(name.id)">Delete</a></td></tr>
          </tbody>
        </table>
        <!-- modal for for creating new product -->
            <div id="modal-product-form" class="modal">
                <div class="modal-content">
                    <h4 id="modal-product-title">Create New Product</h4>
                    <div class="row">
                        <div class="input-field col s12">
                            <input ng-model="name" type="text" class="validate" id="form-name" placeholder="Type name here..." />
                            <label for="name">Name</label>
                        </div>

                        <div class="input-field col s12">
                            <textarea ng-model="description" type="text" class="validate materialize-textarea" placeholder="Type description here..."></textarea>
                            <label for="description">Description</label>
                        </div>


                        <div class="input-field col s12">
                            <input ng-model="price" type="text" class="validate" id="form-price" placeholder="Type price here..." />
                            <label for="price">Price</label>
                        </div>


                        <div class="input-field col s12">
                            <a id="btn-create-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="createProduct()"><i class="material-icons left">add</i>Create</a>

                            <a id="btn-update-product" class="waves-effect waves-light btn margin-bottom-1em" ng-click="updateProduct()"><i class="material-icons left">edit</i>Save Changes</a>

                            <a class="modal-action modal-close waves-effect waves-light btn margin-bottom-1em"><i class="material-icons left">close</i>Close</a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="fixed-action-btn" style="bottom:45px; right:24px;">
          <a class="waves-effect waves-light btn modal-trigger btn-floating btn-large red" href="#modal-product-form" ng-click="clearModal()">
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
      
      $scope.clearModal = function() {
        $scope.name = '';
        $scope.description = '';
        $scope.price = '';
      }
                  
      $scope.deleteProduct = function(id) {
        $http.post("delete_product.php", { 'id' : id }).success(function(response){
          console.log(response.records);
          $http.get("read_all.php").success(function(response){
            $scope.names = response.records;
          });
        });
      }
      
      $scope.readOne = function(id) {
        $http.post("read_one.php", { 'id' : id }).success(function(response) {
          $scope.name = response[0].name;
          $scope.description = response[0].description;
          $scope.price = response[0].price;
          $scope.id = response[0].id;
          console.log(response);
        }).success(function(){
          $('#modal-product-form').openModal();
        });
      }
      
      $scope.createProduct = function () {
        $http.post("create_product.php", {'name' : $scope.name, 'description' : $scope.description, 'price' : $scope.price }).success(function(response){
          console.log(response);
          $http.get("read_all.php").success(function(response){
            $scope.names = response.records;
            $('#modal-product-form').closeModal();
          });
        });
      }
      
      $scope.updateProduct = function () {
        $http.post("update_product.php", {'id' : $scope.id, 'name' : $scope.name, 'description' : $scope.description, 'price' : $scope.price }).success(function(response){
          console.log(response);
          //update feed
          $http.get("read_all.php").success(function(response){
            $scope.names = response.records;
          });
          $('#modal-product-form').closeModal();
          $scope.clearModal();
        });
      }
      
      $http.get("read_all.php").success(function(response){
          $scope.names = response.records;
      });
      
    });
    
    $(document).ready(function(){
      $('.modal-trigger').leanModal();  
    });
    
    //here is a comment
    
  </script>
</html>