<?php
include "include/dbconnect.php";
// if ($_POST['key'] == "getAllUsers") {
//     $tableData = '';
//     $sr = 1;
//     $query = "SELECT * FROM fca_users";
//     $result = mysqli_query($connect,$query);
//     if (mysqli_num_rows($result)>0)
//     {
//         while ($row = mysqli_fetch_array($result))
//         {
//             $query1 = mysqli_query($connect, "select city from fca_user_details where idtag = '".$row['idtag']."' ");
//             $row1 = mysqli_fetch_array($query1);
//             $city = $row1['city'];

//             $buttonActive = (($row['status'] == 1)?'block':'none');
//             $buttonInActive = (($row['status'] == 0)?'block':'none');
//             $tableData .='<tr>
//                 <td>'.$sr.'</td>
//                 <td>'.$row['idtag'].'</td>
//                 <td>'.$row['parent_idtag'].'</td>
//                 <td>'.$row['name'].'</td>
//                 <td>'.$row['mobile'].'</td>
//                 <td>'.$row['email'].'</td>
//                 <td>'.$row1['city'].'</td>
//                 <td> Rs. '.$row['wallet_amount'].'</td>
//                 <td><a href="javaScript:void(0)" title="Active" style="display:'.$buttonActive.'" id="activeBtn'.$row['sno'].'" onclick="activeInactive(\''.$row['sno'].'\',0);" class="btn btn-success"> Active </a>
//                 <a href="javaScript:void(0)" title="Inactive" style="display:'.$buttonInActive.'" id="inactiveBtn'.$row['sno'].'" onclick="activeInactive(\''.$row['sno'].'\',1);" class="btn btn-danger"> Inactive </a> </td>
//             </tr>';
//             $sr++;
//         }
//     }
//     echo $tableData;
// }
if ($_POST['key'] == "activeInactive"){
    $status = $_POST['status'];
    $recordId = $_POST['recordId'];
    $query = "UPDATE fca_users SET status='$status' WHERE sno='$recordId'";
    $result = mysqli_query($connect,$query);
    if ($result){
        echo "success";
    }
}
