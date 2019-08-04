  <?php  
 //fetch.php  
 require_once "../config.php";
 if(isset($_POST["category_id"]))  
 {  
      $query = "SELECT * FROM categories WHERE id = '".$_POST["category_id"]."'";  
      $result = mysqli_query($link, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>