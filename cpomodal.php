<?php  
    
    include 'include/dbconnect.php';

    if(isset($_POST["cpo_id"]))  
    {  
        $output = '';  
          
        $query = mysqli_query($connect, "SELECT * FROM fca_cpo WHERE cpo_id = '".$_POST["cpo_id"]."'" );  
        $fetch = mysqli_fetch_array($query);
        $cpo_name = $fetch['cpo_name'];
        $cpo_mobile = $fetch['cpo_mobile'];
        $cpo_landline = $fetch['cpo_landline'];
        $cpo_email = $fetch['cpo_email'];
        $cpo_address_1 = $fetch['cpo_address_1'];
        $cpo_address_2 = $fetch['cpo_address_2'];
        $cpo_pincode = $fetch['cpo_pincode'];
        $cpo_city = $fetch['cpo_city'];
        $cpo_state = $fetch['cpo_state'];

        $query1 = "SELECT * FROM fca_cpo_bank WHERE cpo_id = '".$_POST["cpo_id"]."'";  
        $result1 = mysqli_query($connect, $query1);  
        $fetch1 = mysqli_fetch_array($result1);
        $cpo_bank_name = $fetch1['cpo_bank_name'];
        $cpo_branch_name = $fetch1['cpo_branch_name'];
        $cpo_account_number = $fetch1['cpo_account_number'];
        $cpo_account_name = $fetch1['cpo_account_name'];
        $cpo_ifsc_code = $fetch1['cpo_ifsc_code'];
        
        $output .= '<div class="table-responsive">  
                        <table class="table table-bordered">
                          <tr>  
                               <th> Name </th>  
                               <td> '.$cpo_name.' </td>  
                          </tr>  
                          <tr>  
                               <th> Mobile Number </th>  
                               <td> '.$cpo_mobile.' </td>  
                          </tr>  
                          <tr>  
                               <th> Landline </label> </th>  
                               <td> '.$cpo_landline.' </td>  
                          </tr>  
                          <tr>  
                               <th> Email ID </label> </th>  
                               <td> '.$cpo_email.' </td>  
                          </tr>
                          <tr>
                              <th> Address Line 1 </th>
                              <td> '.$cpo_address_1.' </td>
                          </tr>
                          <tr>
                              <th> Address Line 2 </th>
                              <td> '.$cpo_address_2.' </td>
                          </tr>
                          <tr>
                              <th> Pincode </th>
                              <td> '.$cpo_pincode.' </td>
                          </tr>
                          <tr>
                              <th> City </th>
                              <td> '.$cpo_city.', '.$cpo_state.' </td>
                          </tr>
                          <tr>
                              <th> Bank Name </th>
                              <td> '.$cpo_bank_name.' </td>
                          </tr>
                          <tr>
                              <th> Branch Name </th>
                              <td> '.$cpo_branch_name.' </td>
                          </tr>
                          <tr>
                              <th> Account Number </th>
                              <td> '.$cpo_account_number.' </td>
                          </tr>
                          <tr>
                              <th> Account Name </th>
                              <td> '.$cpo_account_name.' </td>
                          </tr>
                          <tr>
                              <th> IFSC Code </th>
                              <td> '.$cpo_ifsc_code.' </td>
                          </tr>
                        </table>
                    </div>';  
        
        echo $output;  
    
    }


?>