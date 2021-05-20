<?php
    include_once("navigation.php");
    include_once "php/config.php";
    $sql = mysqli_query($conn, "select * from location");
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
                    </tr>

                    <?php
                        while($row = mysqli_fetch_array($sql))  
                        {  
                                echo '<tr>
                                <td>'.$row['lab_id'].'</td>
                                <td>'.$row['lab_name'].'</td>
                                </tr>';
                        }
                    ?>
                </table>
	            </div>	
            </div>
                



    </div>
</div>

          
			</form></center><br><br><br>

<?php
    include_once("footer.php");
?>
<script>
	const form=document.querySelector("#formpurchase"),
	continueBtn1=form.querySelector("#addcomponent");
	// errorText = form.querySelector(".error-text");


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
