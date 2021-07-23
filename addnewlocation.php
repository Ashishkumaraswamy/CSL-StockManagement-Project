<?php
    session_start();
    include_once "php/config.php";
    $usersql=mysqli_query($conn,"SELECT * FROM users WHERE user_id={$_SESSION['unique_id']}");
    $user=mysqli_fetch_assoc($usersql);
    $sql = mysqli_query($conn, "select * from location");
    if($user['role']!=1)
    {
      header("location: mainpage.php");
    }
    include_once("navigation.php");
?>
<center><h2>ADD NEW LOCATION</h2></center>

<center><form action="" class="form-horizontal" method="post" name="myForm" id="formpurchase">
<br>
<div class="form-group pt-2">
    <div class="form-group">
          	<h4 class="text-center"></h4>
          	<br>
              <div class="row ml-2">

                <div class="col-md-2">
	            </div>

                <div class="col-md-4">
	        		<input type="text" class="form-control" id="location" name="location" placeholder="Location Name">
	        	</div>
	        	<div class="col-md-2">
	        		<button type="submit" class="btn btn-primary" id="addcomponent" name="add">Add to Loaction Table</button>
	        	</div>
              <br><br>
              <br><br>
          		<div class="col-sm-offset-2 col-md-9 text-center">
    			<table class="table table-hover">
                    <tr>
                        <th>Location_ID</th>
                        <th>Location </th>
                        <th>Delete</th>
                    </tr>

                    <?php
                        while($row = mysqli_fetch_array($sql))  
                        { 
                            if($row['lab_name'] == 'STORE' || $row['lab_name'] == 'DISPOSED' ){
								$temp = '<button type="submit" class="btn btn-primary" id="delcomponent" disabled>Not Accessible</button>';
							}else {
								$temp = '<button type="submit" class="btn btn-danger" id="delcomponent" onclick="myFunction('.$row['lab_id'].')">Delete</button>';
							}  
                                echo '<tr>
                                <td>'.$row['lab_id'].'</td>
                                <td>'.$row['lab_name'].'</td>
                                <td>'.$temp.'</td>
                                </tr>';
                        }
                    ?>
                </table>
	            </div>	
            </div>
    </div>
</div>     
</form></center>

<?php
    include_once("footer.php");
?>
<script>
	const form=document.querySelector("#formpurchase");
	continueBtn1=form.querySelector("#addcomponent");
	// errorText = form.querySelector(".error-text");

    function myFunction(a) {

        console.log(a);
        if (confirm("Do you want to delete the delete the location!!")) {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "php/deloaction.php?loc_id="+a, true);
            xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    alert(data);
                }
                }
            }
            let formData = new FormData(form);
            xhr.send();
		
        
        }else{

        }}


	continueBtn1.onclick = (e)=>{

	e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addnewlocation.php", true);
    console.log(xhr.response);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              console.log(data);
			  if(data === "success"){
					alert("New Location has been added Successfully!!");
					document.getElementById("location").value="";
                    window.location.href="addnewlocation.php";
                    //document.getElementById("myForm").action = "addnewlocation.php";
			  }
			  else{
					alert(data);
			  }
          }
      }
    
    }
    let formData = new FormData(form);
    xhr.send(formData);
    
    }

</script>	
</body>
</html>
