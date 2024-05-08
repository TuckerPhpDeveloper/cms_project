<?php  
    
    include 'include/dbconnect.php';

    if(isset($_POST["con_id"]))  
    {  
        
        $con_id = $_POST["con_id"];
        $voltage = $_POST["voltage"];
        $current = $_POST["current"];

        $output = '';  
        

        $output .= '<div class="table-responsive">  
                    
                    <form method = "POST" action="connectorstatus.php?con_id='.$con_id.'&status=3">  
                      <br>
                      <label> Select Unit  </label>
                      <select class="form-control" id="unit" name="unit" required onchange="fun()">
                          <option value=""> Select </option>
                          <option value="w"> Power (W) </option>
                          <option value="a"> Current (A) </option>
                      </select>

                      <br>
                      <div id="limit_set">
                       
                      </div>

                      <br>
                      <!-- <label> Enter Limit(1-'.$current.') </label>
                      <input type="number" class="form-control" id="current" name="current" min="1" max='.$current.' required> -->

                      <br><br>
                      <input type="submit" name="submit" class="btn btn-danger" value = "Send">

                    </form>

                    <script>
                       count = 0;
                      function fun()
                      {
                        var select = document.getElementById("unit").value;

                          if(select == "w")
                          {
                            currentmax = '.$current.'*'.$voltage.';
                          }
                          else if(select == "a")
                          {
                            currentmax = '.$current.';
                          }

                        if(count == 0)
                        {
                           var input_tags = limit_set.getElementsByTagName("input");
                            if(input_tags.length >= 1)
                            {
                              limit_set.removeChild(input_tags[(input_tags.length) - 1]);
                            }
                          var newField = document.createElement("input");
                          newField.setAttribute("type","number");
                          newField.setAttribute("name","limit[]");
                          newField.setAttribute("class","form-control limit_set");
                          newField.setAttribute("size",50);
                          newField.setAttribute("min",1);
                          newField.setAttribute("max",currentmax);
                          newField.setAttribute("placeholder","Enter Limit 1 - "+currentmax);
                          limit_set.appendChild(newField);

                          count++;
                        }
                        else
                        {                                                      
                            var input_tags = limit_set.getElementsByTagName("input");
                            if(input_tags.length >= 1)
                            {
                              limit_set.removeChild(input_tags[(input_tags.length) - 1]);
                            }
                            count = 0;

                          var newField = document.createElement("input");
                          newField.setAttribute("type","number");
                          newField.setAttribute("name","limit[]");
                          newField.setAttribute("class","form-control limit_set");
                          newField.setAttribute("size",50);
                          newField.setAttribute("min",1);
                          newField.setAttribute("max",currentmax);
                          newField.setAttribute("placeholder","Enter Limit 1 - "+currentmax);
                          limit_set.appendChild(newField);

                        }

                      }

                    </script>

                    </div>';  
        echo $output;  
    
    }


?>