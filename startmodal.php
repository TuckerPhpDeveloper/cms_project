<?php  
    
    include 'include/dbconnect.php';

    if(isset($_POST["con_id"]))  
    {  
        
        $con_id = $_POST["con_id"];
        $output = '';  
        

        $output .= '<div class="table-responsive">  
                    
                    <form method = "POST" action="connectorstatus.php?con_id='.$con_id.'&status=1">  
                      <br>
                      <label> Select IdTag </label>
                      <select class="form-control" id="idtag" name="idtag" required>
                          <option value=""> Select IdTag </option>';

                          $query1 = mysqli_query($connect, "select idtag, name from fca_users where status=1");
                          while($row1 = mysqli_fetch_array($query1))
                          {
                            $idtag_db = $row1['idtag'];
                            $name_db = $row1['name'];

                            $output.='<option value='.$idtag_db.'>'.$idtag_db.'</option>'; 
                          }
                          $output.='
                      </select>

                      <br>
                      <label> Enter unit (1 - 50) </label>
                      <input type="number" name="unit" id="unit" class="form-control" required min="1" max="50">

                      <br>
                      <input type="submit" name="submit" class="btn btn-danger" value = "Send">

                    </form>


                      <table class="table table-bordered">';  
                      while($row = mysqli_fetch_array($result))  
                      {  
                          $output .= '<tr>  
                                           <th> Name </th>  
                                           <td> '.$row["cpo_name"].' </td>  
                                      </tr>  
                                      <tr>  
                                           <th> Mobile Number </th>  
                                           <td> '.$row["cpo_mobile"].' </td>  
                                      </tr>  
                                      <tr>  
                                           <th> Landline </label> </th>  
                                           <td> '.$row["cpo_landline"].' </td>  
                                      </tr>  
                                      <tr>  
                                           <th> Email ID </label> </th>  
                                           <td> '.$row["cpo_email"].' </td>  
                                      </tr>
                                      <tr>
                                          <th> Aadhaar </th>
                                          <td> '.$row["cpo_aadhaar"].' </td>
                                      </tr>
                                      <tr>
                                          <th> GST </th>
                                          <td> '.$row["cpo_gst"].' </td>
                                      </tr>
                                      <tr>
                                          <th> PAN </th>
                                          <td> '.$row["cpo_pan"].' </td>
                                      </tr>
                                      <tr>
                                          <th> Address Line 1 </th>
                                          <td> '.$row["cpo_address_1"].' </td>
                                      </tr>
                                      <tr>
                                          <th> Address Line 2 </th>
                                          <td> '.$row["cpo_address_2"].' </td>
                                      </tr>
                                      <tr>
                                          <th> Pincode </th>
                                          <td> '.$row["cpo_pincode"].' </td>
                                      </tr>
                                      <tr>
                                          <th> City </th>
                                          <td> '.$row["cpo_city"].', '.$row["cpo_state"].' </td>
                                      </tr>
                                      <tr>
                                          <th> Bank Name </th>
                                          <td> '.$row["cpo_bank_name"].' </td>
                                      </tr>
                                      <tr>
                                          <th> Branch Name </th>
                                          <td> '.$row["cpo_branch_name"].' </td>
                                      </tr>
                                      <tr>
                                          <th> Account Number </th>
                                          <td> '.$row["cpo_account_number"].' </td>
                                      </tr>
                                      <tr>
                                          <th> Account Name </th>
                                          <td> '.$row["cpo_account_name"].' </td>
                                      </tr>
                                      <tr>
                                          <th> IFSC Code </th>
                                          <td> '.$row["cpo_ifsc_code"].' </td>
                                      </tr>';
                      }

        $output .= "</table></div>";  
        
        echo $output;  
    
    }


?>