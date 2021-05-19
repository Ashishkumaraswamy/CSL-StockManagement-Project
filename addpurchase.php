<?php
    include_once("navigation.php");
?>
<center><h2>NEW PURCHASE ENTRY</h2></center>

<center><form action="" class="form-horizontal" method="post" name="myForm" id="formpurchase">	  
<br>
<div class="form-group pt-2">
            <label for="inputEmail3" class="col-md-5 control-label">Invoice Number</label>
            <div class="col-md-3">
              <input type="text" class="form-control" id="p1" name="invoice" placeholder="Invoice Number" required>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-5 control-label">Purchase Details</label>
            <div class="col-md-3" style="margin:black">
          	
            </div>
          </div>
          <div class="form-group">
          	<h4 class="text-center"> Add Components</h4>
          	<br>
          	<div class="row ml-2">
          		<div class="col-md-2">
	            	<!-- <div class="dropdown"> -->
						<select id="compcat" class="dropdown" name="compcat">
					      <?php
					      		$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category NOT IN ('CPU','SERVER','LAPTOP')");
					      		$output ="";
					      		while($category=mysqli_fetch_assoc($categorysql))
					      		{
					      			$output.='<option value="addNew">'.$category['category'].'</option>
';
					      		}
					      		echo $output;
					      ?>
					  </select>
					   <!--  </ul> -->
				    <!-- </div> -->
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="brand" name="brand" placeholder="Brand">
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="p1" name="type" placeholder="Type">
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="p1" name="compdesc" placeholder="Description">
	        	</div>
	        	<div class="col-md-1">
	        		<input type="text" class="form-control" id="p1" name="compquant" placeholder="Quantity">
	        	</div>
	        	<div class="col-md-1">
	        		<button type="submit" class="btn btn-primary" id="addcomponent" name="add">Add to List</button>
	        	</div>
            </div>
          </div>
          <div class="form-group">
          	<h4 class="text-center"> Add CPU/Server/Laptop</h4>
          	<br>
          	<div class="row ml-2">
          		<div class="col-md-2">
	            	<select id="cpucat" class="dropdown">
					      <?php
					      		$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category IN ('CPU','SERVER','LAPTOP')");
					      		$output ="";
					      		while($category=mysqli_fetch_assoc($categorysql))
					      		{
					      			$output.='<option value="addNew">'.$category['category'].'</option>
';
					      		}
					      		echo $output;
					      ?>
					  </select>
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="p1" name="ram" placeholder="RAM" >
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="p1" name="procseries" placeholder="Processor Series">
	        	</div>
	        	<div class="col-md-1">
	        		<input type="text" class="form-control" id="p1" name="storage" placeholder="Storage">
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="p1" name="cpudesc" placeholder="Description">
	        	</div>
	        	<div class="col-md-1">
	        		<input type="text" class="form-control" id="p1" name="cpuquant" placeholder="Quantity">
	        	</div>
	        	<div class="col-md-1">
	        		<button type="submit" class="btn btn-primary" id="addcpu" name="addcpu">Add to List</button>
	        	</div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-md-9 text-center">
              <button type="submit" class="btn btn-primary" id="add" name="add">Add Purchase</button>
            </div>
          </div>

			</form></center><br><br><br>

<?php
    include_once("footer.php");
?>
<script>
	const form=document.querySelector("#formpurchase"),
	continueBtn1=form.querySelector("#addcomponent"),
	continueBtn2=form.querySelector("#addcpu");
	// errorText = form.querySelector(".error-text");

	continueBtn1.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addcomponent.php", true);
    alert('Here');
    xhr.onload = ()=>{
    	alert('Here');
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
          	alert('Here');
              let data = xhr.response;
              console.log(data);
              alert('Here');
              if(data === "success")
              {

              }else{
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
    continueBtn2.onclick = ()=>{
    alert('Here');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addcpu.php", true);

    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "success"){

              }else{

                errorText.textContent = data;
                errorText.style.height = "45px";
                
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
