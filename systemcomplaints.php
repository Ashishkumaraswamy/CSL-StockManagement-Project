<?php
    include_once("navigation.php");
?>
<center><h2>REPORT PROBLEM</h2></center>

<center><form action="" class="form-horizontal" method="post" name="myForm" id="formcomp">
<br>
  <br>
      <div class="form-check">
    <input type="checkbox" class="form-check-input" id="replacecheck" value="Add System">
    <input type="text" value="uncheck" name="check" id="check" hidden>
    <label class="form-check-label" for="exampleCheck1">Report and Replace Component</label>
  </div>
  		<input type="text" name="radiovalue" id="radiovalue" hidden>
          <div class="form-group" id="inputcompcheck">
            
          </div>
          <div class="form-group" id="assigncomponents">
          	<br><br>
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
                <input type="text" class="form-control" id="compid" name="compid" placeholder="Component ID" required>
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
            <div class="col-md-3">
                <input type="text" class="form-control" id="description" name="description" placeholder="Problem Description" required>
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

			</form></center><br><br><br>


<?php
    include_once("footer.php");
?>
<script>
	const form= document.querySelector("#formcomp");

  document.getElementById("replacecheck").onclick=()=>{
     if(document.getElementById("check").value=="uncheck")
     {
        document.getElementById("check").value="checked";
        document.getElementById("addcomp").innerHTML='<div class="col-md-2"><input type="text" class="form-control" id="compid" name="repcompid" placeholder="Replace Component ID" required></div>';
        
     }
     else{
        document.getElementById("check").value="uncheck";
        document.getElementById("addcomp").innerHTML='';
     }
  }

	document.getElementById("reportproblembtn").onclick=(e)=>{
    e.preventDefault();
    alert('Here');
     let xhr = new XMLHttpRequest();
     xhr.open("POST", "php/systemcomplaint.php", true);
     xhr.onload=()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status===200)
        {
          let data=xhr.response;
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