<?php
    include_once("navigation.php");
?>
<center><form action="" class="form-horizontal" method="post" name="myForm" id="formassign">
<br><br>
            <div class="col-md-3">
            </div>
            <div class="col-md-2">
            <div class="radio">
			    <label style="font-size: 15px"><input type="radio" id="overall" name="overall">Overall  Report</label>
			</div>
            </div>
            <div class="col-md-2">
			<div class="radio">
			  <label style="font-size: 15px"><input type="radio" name="status" id="status">Status Report</label>
			</div>
            </div>
            <div class="col-md-2">
			<div class="radio">
			  <label style="font-size: 15px"><input type="radio" name="labwise" id="labwise">Labwise Report</label>
			</div>
            </div>
          
          <div class="form-group" id="inputcompcheck">
            
          </div>
          <br>

                <div class="form-group" id="overallarea" hidden>
                        <center><h4 class="text-center"><b>Overall Report</b></h4></center>
                        <br><br>

                        <div class="col-md-1">
                        </div>
                    
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Invoice Number" required>
                        </div>

                        <div class="col-md-1">
                            <label for="inputEmail3" class="col-md-5 control-label">From</label>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="from" name="from" placeholder="From Date" required>
                        </div>
                        
                        <div class="col-md-1">
                            <label for="inputEmail3" class="col-md-5 control-label">To</label>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="to" name="to" placeholder="To Date" required>
                        </div>

                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary" id="go" name="go">GO</button>
                        </div>
                
                </div>


                <div class="form-group" id="statusarea" hidden>
                        <center><h4 class="text-center"><b>Status Report</b></h4></center>
                        <br><br>
                    
                        <div class="col-md-3">
                        </div> 

                        <div class="col-md-2">
                        <div class="radio">
                            <label style="font-size: 15px"><input type="radio" id="working" name="working">Working</label>
                        </div>
                        </div>
                        <div class="col-md-2">
                        <div class="radio">
                            <label style="font-size: 15px"><input type="radio" name="notworking" id="notworking">Not Working</label>
                        </div>
                        </div>
                        <div class="col-md-2">
                        <div class="radio">
                            <label style="font-size: 15px"><input type="radio" name="disposed" id="disposed">Disposed</label>
                        </div>
                        </div>
                
                </div>



                <div class="form-group" id="labwisearea" hidden>
                        <center><h4 class="text-center"><b>Labwise Report</b></h4></center>
                        <br><br>
                    
                        <div class="col-md-4">
                        </div> 
                        <div class="col-md-3">
                            <select id="cpucat" name="cpucat" class="dropdown" style="width:270px;height:30px">
                                <?php
                                        $categorysql=mysqli_query($conn,"SELECT * FROM category WHERE category IN ('cpu','server','laptop','mac-desktop')");
                                        $output ="";
                                        while($category=mysqli_fetch_assoc($categorysql))
                                        {
                                            $output.='<option value="'.$category['category'].'">'.$category['category'].'</option>';
                                        }
                                        echo $output;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                        <button type="submit" class="btn btn-primary" id="goo" name="goo">Go</button>
                        </div>

                
                </div>


			</form></center><br><br><br>


<?php
    include_once("footer.php");
?>
<script>
	const form= document.querySelector("#formassign")

	document.getElementById("overall").onclick=(e)=>{
		// document.getElementById("status").style.display="none";
        document.getElementById("statusarea").style.display="none";
        document.getElementById("labwisearea").style.display="none";
        document.getElementById("overallarea").style.display="block";
	}

	document.getElementById("status").onclick=(e)=>{
        // document.getElementById("overall").style.display="none";
        document.getElementById("overallarea").style.display="none";
        document.getElementById("labwisearea").style.display="none";
        document.getElementById("statusarea").style.display="block";
	}
    document.getElementById("labwise").onclick=(e)=>{
        //document.getElementById("radiovalue").value="labwise";
        document.getElementById("overallarea").style.display="none";
        document.getElementById("statusarea").style.display="none";
        document.getElementById("labwisearea").style.display="block";
	}

        document.getElementById("working").onclick=(e)=>{
            alert("working");
        }
        document.getElementById("notworking").onclick=(e)=>{
            alert("notworking");
        }
        document.getElementById("disposed").onclick=(e)=>{
            alert("disposed");
        }
    
    

	
	document.getElementById("assigncomponentbtn").onclick=(e)=>
	{
	alert('Here');
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