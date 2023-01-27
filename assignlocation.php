<?php
	session_start();
	include_once "php/config.php";
    $usersql=mysqli_query($conn,"SELECT * FROM users WHERE user_id={$_SESSION['unique_id']}");
    $user=mysqli_fetch_assoc($usersql);
	if($user['role']!=1)
    {
      header("location: mainpage.php");
    }
	include_once("navigation.php");
?>
<!-- this is a comment -->
<center><form action="" class="form-horizontal" method="post" name="myForm" id="formassign">
<br>
  <br>
  		<input type="text" name="radiovalue" id="radiovalue" hidden>
          <div class="form-group pt-2">
            <div class="radio">
			  <label style="font-size: 16px"><input type="radio" id="compradio" name="optradio">Assign Location To Component</label>
			</div>
			<br>
			<div class="radio">
			  <label style="font-size: 16px"><input type="radio" name="optradio" id="systemtradio">Assign Location To System    </label>
			</div>
          </div>
          <div class="form-group" id="inputcompcheck">
            
          </div>
          <div class="form-group" id="assigncomponents" hidden>
          	<center><h4 class="text-center"></h4>Assign Location To Component</center>
          	<br><br>
          	<div class="row">
          		<div class="col-md-4">
          		</div>
          		<div class="col-md-2">
	              <input type="text" class="form-control" id="assigncomponent" name="assigncomponent" placeholder="Component ID" required>
	            </div>
          		<div class="col-md-2">
      						<select id="compcat" class="dropdown" name="comploc" style="width:130px;height:30px">
      					      <?php
      					      		$categorysql=mysqli_query($conn,"SELECT * FROM location");
      					      		$output ="";
      					      		while($category=mysqli_fetch_assoc($categorysql))
      					      		{
                            if($category['lab_name']!="STORE" and $category['lab_name']!="DISPOSED")
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
	        	<div class="col-md-1">
	        		<button type="submit" class="btn btn-primary" id="assigncomponentbtn" name="add" style="margin-left:50px">Assign Location</button>
	        	</div>
            </div>
          </div>
          <br>
          <div class="form-group" id="assignsystem" hidden>
            <div class="row">
          	<center><h4 class="text-center">Assign Location To System</h4></center>
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
      					      			if($category['lab_name']!="STORE" and $category['lab_name']!="DISPOSED")
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
	        	<div class="col-md-1">
	        		<button type="submit" class="btn btn-primary" id="assignsystembtn" name="add" style="margin-left:50px">Assign Location</button>
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
	const form= document.querySelector("#formassign")
	document.getElementById("systemtradio").onclick=(e)=>{
		document.getElementById("radiovalue").value="systemradio";
		document.getElementById("assigncomponents").style.display="none";
		document.getElementById("assignsystem").style.display="block";
	}

	document.getElementById("compradio").onclick=(e)=>{
		document.getElementById("radiovalue").value="compradio";
		document.getElementById("assignsystem").style.display="none";
		document.getElementById("assigncomponents").style.display="block";
	}

	document.getElementById("assignsystembtn").onclick=(e)=>{
		e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/assignsystem.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
	          let data = xhr.response;
	          alert(data);
            location.href("assignlocation.php");
	      	}
    	}
	}
    let formData = new FormData(form);
    xhr.send(formData);
	}

	document.getElementById("assigncomponentbtn").onclick=(e)=>
	{
	e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/assigncomponent.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
	          let data = xhr.response;
	          alert(data);
            location.href("assignlocation.php");
	      	}
    	}
	}
    let formData = new FormData(form);
    xhr.send(formData);
	}
</script>
</body>
</html>