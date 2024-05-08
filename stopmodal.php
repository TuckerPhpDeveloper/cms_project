<?php  
    
    include 'include/dbconnect.php';

    if(isset($_POST["con_id"]))  
    {  
        
        $con_id = $_POST["con_id"];
        $output = '';  
        

        $output .= '<div class="table-responsive">  
                    
                    <form method = "POST" action="connectorstatus.php?con_id='.$con_id.'&status=2">  
                      <br>
                      <label> Select Transaction ID </label>
                      <select class="form-control" id="trans_id" name="trans_id" required>
                          <option value=""> Select Transaction ID </option>';

                          $query1 = mysqli_query($connect, "select transaction_id from fca_transaction where status=0");
                          while($row1 = mysqli_fetch_array($query1))
                          {
                            $transaction_id_db = $row1['transaction_id'];
 
                            $output.='<option value='.$transaction_id_db.'>'.$transaction_id_db.'</option>'; 
                          }
                          $output.='
                      </select>

                      <br><br>
                      <input type="submit" name="submit" class="btn btn-danger" value = "Send">

                    </form>

                    </div>';  
        
        echo $output;  
    
    }


?>