 
  <?php  
 if(isset($_POST["category_id"]))  
 {  
      $output = '';  
       require_once "../config.php";

      $query = "SELECT * FROM categories WHERE id = '".$_POST["category_id"]."'";  
      $result = mysqli_query($link, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td width="30%"><label>Name</label></td>  
                     <td width="70%">'.$row["category"].'</td>  
                </tr>  

           ';  
      }  
      $output .= '  
           </table>  
      </div>  
      ';  
      echo $output;  
 }  
 ?>