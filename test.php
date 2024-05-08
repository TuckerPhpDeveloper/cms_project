<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title> Tucker CMS </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
</head>
<body>

<?php
  $connect=mysqli_connect("103.83.81.25","test_user","J4I&cEkaZ","plant_test");
?>
            
            <br><br>
            <div class="container">

                <div class="pd-20 card-box mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h4 style="color: #3d56d8;"> SLDC Breaker Status </h4>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Plant Name </th>
                                        <th> Status </th>
                                        <th> Update </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sr = 1;
                                        $query = "SELECT * FROM gounder";
                                        $result = mysqli_query($connect,$query);
                                        if (mysqli_num_rows($result)>0)
                                        {
                                            while($row = mysqli_fetch_array($result))
                                            {
                                                $breaker_db = $row['digital'];

                                                if($breaker_db=='0')
                                                    $breaker = "Open";
                                                else
                                                    $breaker = "Close";

                                                $buttonActive = (($row['digital'] == 1)?'block':'none');
                                                $buttonInActive = (($row['digital'] == 0)?'block':'none');

                                                ?>
                                                <tr>
                                                    <td><?php echo $sr; ?></td>
                                                    <td><?php echo "Gounder"; ?></td>
                                                    <td> <?php echo $breaker; ?> </td>
                                                    <td><a href="javaScript:void(0)" title="Active" style="display: <?php echo $buttonActive; ?>" id="activeBtn"<?php echo $row['id']; ?> onclick="activeInactive(<?php echo $row['id']; ?>,0);" class="btn btn-success"> Click to Open </a>
                                                    <a href="javaScript:void(0)" title="Inactive" style="display:<?php echo $buttonInActive; ?>" id="inactiveBtn"<?php echo $row['id']; ?> onclick="activeInactive(<?php echo $row['id']; ?>,1);" class="btn btn-danger"> Click to Close </a> </td>
                                                </tr>
                                                <?php
                                                $sr++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>

                            <script type="text/javascript">
                                function activeInactive(recordId,status)
                                {
                                    var message = ((status == 0?" inactive ":" Active "));
                                    if(confirm("Are you sure to"+ message+ "the user"))
                                    {
                                        $.post("script.php",{key:"activeInactive",status:status,recordId:recordId},function (response)
                                        {
                                            if (response == "success")
                                            {
                                                if (status == 1)
                                                {
                                                    $('#activeBtn'+recordId).show();
                                                    $('#inactiveBtn'+recordId).hide();
                                                }
                                                else if (status == 0)
                                                {
                                                    $('#inactiveBtn'+recordId).show();
                                                    $('#activeBtn'+recordId).hide();
                                                }
                                                window.location.href = 'test.php';
                                                // alert("User is "+ message +"now");
                                            }
                                        });
                                    }
                                }
                            </script>


                        </div>
                    </div>

                </div>
            </div>

    <!-- js -->

    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>

</body>
</html>