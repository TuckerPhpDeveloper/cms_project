<?php  
    
    include 'include/dbconnect.php';

    if(isset($_POST["cms_id"]))  
    {  
        $output = '';  
          
        $query = mysqli_query($connect, "SELECT * FROM fca_cms_login WHERE cms_id = '".$_POST["cms_id"]."'" );  
        $fetch = mysqli_fetch_array($query);
        $cms_id = $fetch['cms_id'];
        $username = $fetch['username'];
        $password = $fetch['password'];
        $name = $fetch['name'];
        $mobile = $fetch['mobile'];
        $email = $fetch['email'];
        $designation = $fetch['designation'];
        $permission = $fetch['permission'];


        
        $output .= '<div class="table-responsive">  
                        <table class="table table-bordered">
                          <tr>  
                               <th> CMS ID </th>  
                               <td> '.$cms_id.' </td>  
                          </tr>  
                          <tr>  
                               <th> username </th>  
                               <td> '.$username.' </td>  
                          </tr>  
                          <tr>  
                               <th> Password </th>  
                               <td> '.$password.' </td>  
                          </tr>  
                          <tr>  
                               <th> Name </th>  
                               <td> '.$name.' </td>  
                          </tr>  
                          <tr>  
                               <th> Mobile Number </th>  
                               <td> '.$mobile.' </td>  
                          </tr>  
                          <tr>  
                               <th> Email ID </label> </th>  
                               <td> '.$email.' </td>  
                          </tr>  
                          <tr>  
                               <th> Designation </label> </th>  
                               <td> '.$designation.' </td>  
                          </tr>
                        </table>
                    </div>';  
        
        echo $output;  
    
    }


?>