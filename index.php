<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include "services/api.php";

if(isset($_POST['name']) && $_POST['name'] != ''){

      $api = new API();
      $res = $api->processApi(); 
    
      

}

if(isset($_GET['x']) && $_GET['x'] != ''){
	  
	  $api = new API();
      $res = $api->processApi(); 
   
}

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
</head>

<body>
<form method="post">
  <div class="form-group">
    <label for="email">name</label>
    <input class="form-control" id="name" name="name">
  </div>
  <div class="form-group">
    <label for="pwd">Hashkey:</label>
    <input type="password" class="form-control" id="hashkey" name="hashkey">
  </div>
  <input type="hidden" id="x1" name="x1" value="insertCustomertest" />
  <input type="submit" class="btn btn-default" value="Create" id="wallet" name="wallet"/>

  <div id="result">

  </div>
</form>
</body>
</html>