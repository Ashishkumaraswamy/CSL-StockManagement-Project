<?php
    include_once("navigation.php");
?>
<center><h2>NEW PURCHASE ENTRY</h2></center>

<center><form action="" class="form-horizontal" method="post" name="myForm" id="formpurchase">
<br>
<div class="form-group pt-2">
            <label for="inputEmail3" class="col-md-5 control-label">Invoice Number</label>
            <div class="col-md-2">
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
          	<div class="row">
          		<div class="col-md-2">
      						<select id="compcat" class="dropdown" name="compcat" style="width:130px;height:30px">
      					      <?php
      					      		$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category NOT IN ('CPU','SERVER','LAPTOP')");
      					      		$output ="";
      					      		while($category=mysqli_fetch_assoc($categorysql))
      					      		{
      					      			$output.='<option value="'.$category['category'].'">'.$category['category'].'</option>
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
	        		<input type="text" class="form-control" id="type" name="type" placeholder="Type">
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="compdesc" name="compdesc" placeholder="Description">
	        	</div>
	        	<div class="col-md-1">
	        		<input type="text" class="form-control" id="compquant" name="compquant" placeholder="Quantity">
	        	</div>
	        	<div class="col-md-1">
	        		<button type="submit" class="btn btn-primary" id="addcomponent" name="add">Add to List</button>
	        	</div>
            </div>
          </div>
          <br>
          <div class="form-group mt-2">
          	<h4 class="text-center"> Add CPU/Server/Laptop</h4>
          	<br>
          	<div class="row">
          		<div class="col-md-2">
	            	<select id="cpucat" name="cpucat" class="dropdown" style="width:130px;height:30px">
					      <?php
					      		$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category IN ('CPU','SERVER','LAPTOP')");
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
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="ram" name="ram" placeholder="RAM" >
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="procseries" name="procseries" placeholder="Processor Series">
	        	</div>
	        	<div class="col-md-1">
	        		<input type="text" class="form-control" id="storage" name="storage" placeholder="Storage">
	        	</div>
	        	<div class="col-md-2">
	        		<input type="text" class="form-control" id="cpudesc" name="cpudesc" placeholder="Description">
	        	</div>
	        	<div class="col-md-1">
	        		<input type="text" class="form-control" id="cpuquant" name="cpuquant" placeholder="Quantity">
	        	</div>
	        	<div class="col-md-1">
	        		<button type="submit" class="btn btn-primary" id="addcpu" name="addcpu">Add to List</button>
	        	</div>
            </div>
          </div>
          <br>
          <br>
          <div class="form-group">
            <div class="col-sm-offset-2 col-md-9 text-center">
              <button type="submit" class="btn btn-primary pt-5" id="add" name="add">Add Purchase</button>
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


	continueBtn1.onclick = (e)=>{

	e.preventDefault();
	console.log(document.getElementById("compcat").value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addcomponent.php", true);
    console.log(xhr.response);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
          	alert('Here');
              let data = xhr.response;
              console.log(data);
              alert('Here');
             document.getElementById("brand").value="";
             document.getElementById("type").value="";
             document.getElementById("compdesc").value="";
             document.getElementById("type").value="";
             document.getElementById("compquant").value="";
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
    continueBtn2.onclick = (e)=>{
    e.preventDefault();
    alert("Here");
    console.log(document.getElementById("cpucat").value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addcpu.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          alert('Here');
          if(xhr.status === 200){
              let data = xhr.response;
              console.log(data);
              document.getElementById("ram").value="";
              document.getElementById("procseries").value="";
              document.getElementById("storage").value="";
              document.getElementById("cpudesc").value="";
              document.getElementById("cpuquant").value="";
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
</script>	
</body>
</html>
