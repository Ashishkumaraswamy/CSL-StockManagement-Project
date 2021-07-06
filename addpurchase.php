<?php
    include_once("navigation.php");
?>
<center><h2>NEW PURCHASE ENTRY</h2></center>

<center><form action="" class="form-horizontal" method="post" name="myForm" id="formpurchase">
<br>
 <div class="form-check">
    <input type="checkbox" class="form-check-input" id="systemcheck" value="Add System">
    <input type="text" value="uncheck" id="check" hidden>
    <label class="form-check-label" for="exampleCheck1">Add System</label>
  </div>
  <br>
          <div class="form-group pt-2">
            <label for="inputEmail3" class="col-md-5 control-label">Invoice Number</label>
            <div class="col-md-2">
              <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Invoice Number" required>
            </div>
          </div>
          <div class="form-group pt-2">
            <label for="inputEmail3" class="col-md-5 control-label">Invoice Date</label>
            <div class="col-md-2">
              <input type="date" class="form-control" id="date" name="date" placeholder="Invoice Date" required>
            </div>
          </div>
          <div class="form-group" id="inputcompcheck">
            
          </div>
          <div class="form-group">
          	<h4 class="text-center"> Add Components</h4>
          	<br>
          	<div class="row">
          		<div class="col-md-2">
      						<select id="compcat" class="dropdown" name="compcat" style="width:130px;height:30px">
      					      <?php
      					      		$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category_code NOT IN ('CPU','SRV','LAP','MAC')");
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
					      		$categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category_code IN ('CPU','SRV','LAP','MAC')");
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
	        		<input type="text" class="form-control" id="storage" name="storage" placeholder="Storage(GB): Example 1000">
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
            <div class="row" id="assemblesystemdiv">

            </div>
            <div class="row">
            	<div class="col-sm-offset-2 col-md-9 text-center" id="assemblesystem">

            	</div>
           	</div>
            <br>
            <br>
            <div class="row" id="finish">
                <center><button type="submit" class="btn btn-primary" id="finishbtn" name="finish">Finish Purchase Details</button></center>
            </div>
          </div>
          <br>
          <br>

			</form></center><br><br><br>

<?php
    include_once("footer.php");
?>
<script>
	const form=document.querySelector("#formpurchase"),
	continueBtn1=form.querySelector("#addcomponent"),
	continueBtn2=form.querySelector("#addcpu");
  continuebtn3=form.querySelector("#assignsystem");
	var count=0;
	var comp=["CPU","MNT","MOU","KBD"];
	// errorText = form.querySelector(".error-text");

	document.getElementById("systemcheck").onclick=()=>{
		if(document.getElementById("check").value=="uncheck")
		{
      count=0;
			document.getElementById("check").value="check";
			if(count==0)
			{
				document.getElementById("inputcompcheck").innerHTML='<div class="alert alert-info"><strong>Component 1: Enter Mouse details of the Systems Puchased.</strong></div>';
				document.getElementById("compcat").value="Mouse";
        document.getElementById("cpucat").value="";
        $('#addcpu').prop("disabled",true);
			}
		}
    else if(document.getElementById("check").value=="check" && count>0 && count<4)
    {
        alert('System details must be finished before entering other components');
        document.getElementById("systemcheck").checked=true;
    }
		else{
      $('#addcpu').prop("disabled",false);
      $('#addcomponent').prop("disabled",false);
      document.getElementById("inputcompcheck").innerHTML='';
			document.getElementById("check").value="uncheck";
			count=0;
		}
	}

	continueBtn1.onclick = (e)=>{

	e.preventDefault();
	console.log(document.getElementById("compcat").value);
    document.getElementById("assemblesystemdiv").innerHTML="";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addcomponent.php", true);
    console.log(xhr.response);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
             if(parseInt(data.slice(-1))>=0 && parseInt(data.slice(-1))<=9)
             { 
               alert(data);
               document.getElementById("assemblesystemdiv").innerHTML="";
               document.getElementById("brand").value="";
               document.getElementById("type").value="";
               document.getElementById("compdesc").value="";
               document.getElementById("type").value="";
               if(document.getElementById("check").value!="check")
               {
               	document.getElementById("compquant").value="";
                $('#addcpu').prop("disabled",false);
                $('#addcomponent').prop("disabled",false);
               }
               else
               {
                  $('#addcpu').prop("disabled",true);
                 	count=count+1;
                 	if(count==1)
                 	{
                 		document.getElementById("inputcompcheck").innerHTML='<div class="alert alert-info"><strong>Component 2: Enter Monitor details of the Systems Puchased.</strong></div>';
                 		document.getElementById("compcat").value="Monitor";
                 	}
                 	else if(count==2)
                 	{
                 		document.getElementById("inputcompcheck").innerHTML='<div class="alert alert-info"><strong>Component 3: Enter KeyBoard details of the Systems Puchased.</strong></div>';
                 		document.getElementById("compcat").value="Keyboard";
                 	}
                 	else if(count==3)
                 	{
                 		document.getElementById("inputcompcheck").innerHTML='<div class="alert alert-info"><strong>Component 4: Enter CPU details of the Systems Puchased.</strong></div>';
                    document.getElementById("compcat").value="";
                 		document.getElementById("cpucat").value="CPU";
                 		document.getElementById("cpuquant").value=document.getElementById("compquant").value;
                    document.getElementById("compquant").value="";
                    $('#addcpu').prop("disabled",false);
                    $('#addcomponent').prop("disabled",true);
                 	}
                }
              }
              else
              {
                alert(data);
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
    continueBtn2.onclick = (e)=>{
    e.preventDefault();
    console.log(document.getElementById("cpucat").value);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addcpu.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(parseInt(data.slice(-1))>=0 && parseInt(data.slice(-1))<=9)
              {
                alert(data);
                if(document.getElementById("check").value=="check" && count==3)
                {
                  count=count+1;
                  document.getElementById("ram").value="";
                  document.getElementById("procseries").value="";
                  document.getElementById("storage").value="";
                  document.getElementById("cpudesc").value="";
                  if(count==4)
                  {
                  	   document.getElementById("compquant").value="";
                       document.getElementById("assemblesystem").style.display="block";
                       document.getElementById("inputcompcheck").innerHTML='<div class="alert alert-info"><strong>Great All Details of System submitted. Click Assemble System to Assign Components.</strong></div>';
                  	   document.getElementById("assemblesystem").innerHTML='<br><center><button type="submit" class="btn btn-primary" id="assignsystem" name="assignsystem">Assemble System</button><center>';
                       document.getElementById("finish").style.display="none";
                       $('#addcpu').prop("disabled",false);
                       $('#addcomponent').prop("disabled",false);
                       count=0;
                  }
                }
                else
                {
                  $('#addcpu').prop("disabled",false);
                  $('#addcomponent').prop("disabled",false);
                }
              }
              else
              {
                alert(data);
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}


$(document).on('click','#assignsystem',function(e){
  e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/assemblesystem.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              document.getElementById("assemblesystemdiv").innerHTML=data;
              document.getElementById("inputcompcheck").innerHTML='';
              document.getElementById("assignsystem").style.display="none";
              document.getElementById("cpuquant").value="";
              document.getElementById("compcat").value="mouse";
              document.getElementById("systemcheck").checked=false;
              document.getElementById("check").value="uncheck";
          }
      }
    }
    let formData = new FormData();
    formData.append("invoice_id",document.getElementById("invoice").value);
	formData.append("date",document.getElementById("date").value);
    formData.append("quantity",document.getElementById("cpuquant").value);
    formData.append("date",document.getElementById("date").value);
    xhr.send(formData);
});

document.getElementById("finishbtn").onclick=(e)=>{
  e.preventDefault();
  window.onbeforeunload = null;
  let xhr=new XMLHttpRequest();
  xhr.open("POST", "php/insertinvoice.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              console.log(data);
              location.href="addpurchase.php";
          }
      }
    }
    let formData = new FormData();
    formData.append("invoice_id",document.getElementById("invoice").value);
    xhr.send(formData);
}

$(document).on('click','#okaybtn',function(e){
    e.preventDefault();
   document.getElementById("assemblesystemdiv").innerHTML=""; 
   document.getElementById("finish").style.display="block";
});

window.onbeforeunload = function(){
            return 'Are you sure you want to leave?';
};
// window.onbeforeunload = confirmExit;
//     function confirmExit() {
//         return "You have attempted to leave this page. Are you sure?";
// }
// $(document).on('click','#okay',function(e){
//     location.href="addpurchase.php";
// });
</script>	
</body>
</html>
