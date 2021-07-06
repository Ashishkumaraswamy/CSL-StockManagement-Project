<?php
    include_once("navigation.php");
?>
<center><form action="" class="form-horizontal" method="post" name="myForm" id="formassign">
<br><br>
            <div class="col-md-1">
            </div>
            <div class="col-md-3">
            <div class="radio">
              <label style="font-size: 15px"><input type="radio" name="reporttype" id="transfer">Transfer Component</label>
            </div>
            </div>
            <div class="col-md-3">
            <div class="radio">
              <label style="font-size: 15px"><input type="radio" name="reporttype" id="report">Change status of a component</label>
            </div>
            </div>
            <div class="col-md-3">
            <div class="radio">
                <label style="font-size: 15px"><input type="radio" id="reportandreplace" name="reporttype">Change status and replace a component</label>
            </div>
            <div class="col-md-1">
            </div>
            </div>            

          <br>
          <br>
          <br>
          <br>
          <br>
                <input type="text" name="invoicecheck" id="invoicecheck" value="uncheck" hidden>
                <div class="form-group" id="reportproblemdiv" hidden>
                        <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-2">
                            <select id="compcat" class="dropdown" name="compcat" style="width:130px;height:30px">
                                <?php
                                    $categorysql=mysqli_query($conn,"SELECT * FROM category");
                                    $output ="";
                                    while($category=mysqli_fetch_assoc($categorysql))
                                    {
                                      $output.='<option value="'.$category['category'].'">'.$category['category'].'</option>
                ';
                                    }
                                    echo $output;
                                ?>
                        </select>
                      </div>
                        <div class="col-md-1">
                          <input type="text" class="form-control" id="compid" name="compid" placeholder="Component ID">
                        </div>
                      <div id="addcomp">
                      </div>
                      <div class="col-md-2">
                            <select id="compstat" class="dropdown" name="compstat" style="width:130px;height:30px">
                                <?php
                                    $statussql=mysqli_query($conn,"SELECT * FROM status");
                                    $output ="";
                                    while($status=mysqli_fetch_assoc($statussql))
                                    {
                                      $output.='<option value="'.$status['status'].'">'.$status['status'].'</option>
                ';
                                    }
                                    echo $output;
                                ?>
                      </select> 
                      </div>
                      <div class="col-md-2">
                          <center><input type="text" class="form-control" id="description" name="description" placeholder="Problem Description"></center>
                        </div> 
                    </div>
                    <br>
          <br>
          <br>
          <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary" id="reportproblembtn" name="add">Report Problem</button>
            </div>
            </div>
          </div>

              <div class="form-group" id="reportandreplacediv" hidden>
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-2">
                            <select id="compcat" class="dropdown" name="compcat1" style="width:130px;height:30px">
                                <?php
                                    $categorysql=mysqli_query($conn,"SELECT * FROM category");
                                    $output ="";
                                    while($category=mysqli_fetch_assoc($categorysql))
                                    {
                                      $output.='<option value="'.$category['category'].'">'.$category['category'].'</option>
                ';
                                    }
                                    echo $output;
                                ?>
                        </select>
                      </div>
                        <div class="col-md-1">
                          <input type="text" class="form-control" id="compid" name="compid1" placeholder="Component ID">
                        </div>
                      <div class="col-md-2">
                          <input type="text" class="form-control" id="repcompid" name="repcompid" placeholder="Replace Component ID">
                        </div>
                      <div class="col-md-2">
                            <select id="compstat" class="dropdown" name="compstat1" style="width:130px;height:30px">
                                <?php
                                    $statussql=mysqli_query($conn,"SELECT * FROM status");
                                    $output ="";
                                    while($status=mysqli_fetch_assoc($statussql))
                                    {
                                      $output.='<option value="'.$status['status'].'">'.$status['status'].'</option>
                ';
                                    }
                                    echo $output;
                                ?>
                      </select> 
                      </div>
                      <div class="col-md-3">
                          <input type="text" class="form-control" id="description" name="description1" placeholder="Problem Description">
                        </div> 
                    </div>
                      <br>
                      <br>
                  <br>
                  <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                      <button type="submit" class="btn btn-primary" id="reportreplacebtn" name="reportreplacebtn">Report and Replace</button>
                    </div>
                    </div>
                  </div>
                          <div class="form-group" id="reportproblemdiv" hidden>
                      <div class="row">
                      <div class="col-md-1">
                      </div>
                      <div class="col-md-2">
                          <select id="compcat" class="dropdown" name="compcat" style="width:130px;height:30px">
                              <?php
                                  $categorysql=mysqli_query($conn,"SELECT * FROM category");
                                  $output ="";
                                  while($category=mysqli_fetch_assoc($categorysql))
                                  {
                                    $output.='<option value="'.$category['category'].'">'.$category['category'].'</option>
              ';
                                  }
                                  echo $output;
                              ?>
                      </select>
                    </div>
                      <div class="col-md-1">
                        <input type="text" class="form-control" id="compid" name="compid" placeholder="Component ID">
                      </div>
                    <div id="addcomp">
                    </div>
                    <div class="col-md-2">
                          <select id="compstat" class="dropdown" name="compstat" style="width:130px;height:30px">
                              <?php
                                  $statussql=mysqli_query($conn,"SELECT * FROM status");
                                  $output ="";
                                  while($status=mysqli_fetch_assoc($statussql))
                                  {
                                    $output.='<option value="'.$status['status'].'">'.$status['status'].'</option>
              ';
                                  }
                                  echo $output;
                              ?>
                    </select> 
                    </div>
                    <div class="col-md-2">
                        <center><input type="text" class="form-control" id="description" name="description" placeholder="Problem Description"></center>
                      </div> 
                  </div>
                  <br>
        <br>
        <br>
        <div class="row">
          <div class="col-md-5"></div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary" id="reportproblembtn" name="add">Report Problem</button>
          </div>
          </div>
        </div>
        <div class="form-group" id="transfersystem" hidden>
            <div class="row">
          	<center><h4 class="text-center">Transfer System</h4></center>
            </div>
            <br>
            <br>
          	<div class="row">
          		<div class="col-md-3">
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" id="assignsystem" name="fromassignsystem" placeholder="From System ID" required>
              </div>
          		<div class="col-md-2">
	              <input type="text" class="form-control" id="assignsystem" name="toassignsystem" placeholder="To System ID" required>
	            </div>
          		<div class="col-md-2">
      						<select id="compcat" class="dropdown" name="sysloc" style="width:130px;height:30px">
      					      <?php
      					      		$categorysql=mysqli_query($conn,"SELECT * FROM location");
      					      		$output ="";
      					      		while($category=mysqli_fetch_assoc($categorysql))
      					      		{
      					      			if($category['lab_name']!="store" and $category['lab_name']!="disposed")
                            { 
                              $output.='<option value="'.$category['lab_name'].'">'.$category['lab_name'].'</option>';
                            }
      					      		}
      					      		echo $output;
      					      ?>
					  </select>
					   <!--  </ul> -->
				    <!-- </div> -->
	        	</div>
	        </div>
          <br>
          <br>
	        <div class="row">
	        	<div class="col-md-5"></div>
	        	<div class="col-md-2">
	        		<button type="submit" class="btn btn-primary" id="transferbtn" name="add">Transfer System</button>
	        	</div>
            </div>
          </div>
          <br>
          <br>

      </form></center><br><br><br>
<?php
    include_once("footer.php");
?>
<script>
    const form= document.querySelector("#formassign");

    document.getElementById("transfer").onclick=(e)=>{
        document.getElementById("reportandreplacediv").style.display="none";
        document.getElementById("reportproblemdiv").style.display="none";
        document.getElementById("transfersystem").style.display="block";
    }

    document.getElementById("report").onclick=(e)=>{
        document.getElementById("reportandreplacediv").style.display="none";
        document.getElementById("reportproblemdiv").style.display="block";
        document.getElementById("transfersystem").style.display="none";
    }

    document.getElementById("reportandreplace").onclick=(e)=>{
        document.getElementById("reportproblemdiv").style.display="none";
        document.getElementById("reportandreplacediv").style.display="block";
        document.getElementById("transfersystem").style.display="none";
    }
    
    document.getElementById("reportproblembtn").onclick=(e)=>
    {
        alert(document.getElementById("compid").value);
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/reportproblem.php", true);
        xhr.onload = ()=>{
          if(xhr.readyState === XMLHttpRequest.DONE){
              if(xhr.status === 200){
                  let data = xhr.response;
                  alert(data);
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }

    document.getElementById("reportreplacebtn").onclick=(e)=>
    {   
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/reportreplace.php", true);
        xhr.onload = ()=>{
          if(xhr.readyState === XMLHttpRequest.DONE){
              if(xhr.status === 200){
                  let data = xhr.response;
                  alert(data);
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }
    document.getElementById("transferbtn").onclick=(e)=>
    {   
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/transfersystem.php", true);
        xhr.onload = ()=>{
          if(xhr.readyState === XMLHttpRequest.DONE){
              if(xhr.status === 200){
                  let data = xhr.response;
                  alert(data);
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }

</script>
</body>
</html>