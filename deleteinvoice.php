<?php
	include_once "php/config.php";
	$usersql=mysqli_query($conn,"SELECT * FROM users WHERE user_id={$_SESSION['unique_id']}");
	$user=mysqli_fetch_assoc($usersql);
	if($user['role']!=1)
    {
      header("location: mainpage.php");
    }
	include_once("navigation.php");
?>
<br>
<center><h2>Delete Invoice</h2></center>

<center><form action="" class="form-horizontal" method="post" name="myForm" id="deleteinvoiceform">
<br>
<div class="form-group pt-2">
            
          <div class="form-group">
          	<h4 class="text-center"></h4>
          	<br>
          	<div class="row ml-2">
          		<div class="col-md-2">
	            	
	        	</div>
	        	<div class="col-md-2">
	        	</div>
                
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="invoicenumber" name="invoicenumber" placeholder="Invoice Number">
	        	</div>
                
	        	<div class="col-md-2">
	        		<button type="submit" class="btn btn-danger" id="deleteinvoice" name="add" >Delete Invoice</button>
	        	</div>
            </div>
          </div>
          
		</form></center><br><br><br>

<?php
    include_once("footer.php");
?>
<script>
	const form= document.querySelector("#deleteinvoiceform")

	document.getElementById("deleteinvoice").onclick=(e)=>{
		e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/deleteinvoice.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
	          let data = xhr.response;
	          alert(data);
            location.href("deleteinvoice.php");
	      	}
    	}
	}
    let formData = new FormData(form);
    xhr.send(formData);
	}
</script>