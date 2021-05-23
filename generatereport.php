<?php
    include_once("navigation.php");
?>
<center><form action="" class="form-horizontal" method="post" name="myForm" id="formassign">
<br><br>
            <div class="col-md-3">
            </div>
            <div class="col-md-2">
            <div class="radio">
			    <label style="font-size: 15px"><input type="radio" id="overall" name="reporttype">Overall  Report</label>
			</div>
            </div>
            <div class="col-md-2">
			<div class="radio">
			  <label style="font-size: 15px"><input type="radio" name="reporttype" id="status">Status Report</label>
			</div>
            </div>
            <div class="col-md-2">
			<div class="radio">
			  <label style="font-size: 15px"><input type="radio" name="reporttype" id="labwise">Labwise Report</label>
			</div>
            </div>
          <br>
          <br>
                <input type="text" name="invoicecheck" id="invoicecheck" value="uncheck" hidden>
                <div class="form-group" id="overallarea" hidden>
                        <center><h4 class="text-center"><b>Overall Report</b></h4></center>
                        <br><br>
                        <div class="row">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="invoicechkbox" name="invoicechkbox" value="invoiceid">
                                <label class="form-check-label" for="exampleCheck1">Generate Report By Invoice ID</label>
                              </div>
                        </div>
                        <br><br><br>
                        <div id="areabasedoncheck">
                            <div class="col-md-3">
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
                        </div>

                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary" id="invoicebtn" name="invoicebtn">GO</button>
                        </div>
                </div>

                <div class="form-group" id="statusarea" hidden>
                        <center><h4 class="text-center"><b>Status Report</b></h4></center>
                        <br><br>
                    
                        <div class="col-md-3">
                        </div> 

                        <div class="col-md-2">
                        <div class="radio">
                            <label style="font-size: 15px"><input type="radio" id="working" name="radiostatus">Working</label>
                        </div>
                        </div>
                        <div class="col-md-2">
                        <div class="radio">
                            <label style="font-size: 15px"><input type="radio" name="radiostatus" id="notworking">Not Working</label>
                        </div>
                        </div>
                        <div class="col-md-2">
                        <div class="radio">
                            <label style="font-size: 15px"><input type="radio" name="radiostatus" id="disposed">Disposed</label>
                        </div>
                        </div>
                
                </div>



                <div class="form-group" id="labwisearea" hidden>
                        <center><h4 class="text-center"><b>Labwise Report</b></h4></center>
                        <br><br>
                        <div class="col-md-4">
                        </div> 
                        <div class="col-md-3">
                            <select id="cpucat" name="labcat" class="dropdown" style="width:270px;height:30px">
                                <?php
                                        $categorysql=mysqli_query($conn,"SELECT * FROM location");
                                        $output ="";
                                        while($category=mysqli_fetch_assoc($categorysql))
                                        {
                                            $output.='<option value="'.$category['lab_name'].'">'.$category['lab_name'].'</option>';
                                        }
                                        echo $output;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                        <button type="submit" class="btn btn-primary" id="labreportbtn" name="goo">Go</button>
                        </div>

                
                </div>
                <div class="form-group" id="okaybutton" hidden>
                    <div class="form-group" id="reportarea">
                    
                    </div>
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary" id="okaybtn" name="goo">Okay</button>
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
        document.getElementById("okaybutton").style.display="none";
        document.getElementById("overallarea").style.display="block";
	}

	document.getElementById("status").onclick=(e)=>{
        // document.getElementById("overall").style.display="none";
        document.getElementById("overallarea").style.display="none";
        document.getElementById("labwisearea").style.display="none";
        document.getElementById("okaybutton").style.display="none";
        document.getElementById("statusarea").style.display="block";

	}
    document.getElementById("labwise").onclick=(e)=>{
        //document.getElementById("radiovalue").value="labwise";
        document.getElementById("overallarea").style.display="none";
        document.getElementById("statusarea").style.display="none";
        document.getElementById("okaybutton").style.display="none";
        document.getElementById("labwisearea").style.display="block";
	}

        document.getElementById("working").onclick=(e)=>{
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "php/working.php", true);
            xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);
                    document.getElementById("reportarea").innerHTML=data;
                    if(data.length>200)
                    {
                            document.getElementById("okaybutton").style.display="block";
                    }
                    }
                }
            }
            let formData = new FormData(form);
            xhr.send(formData);
        }

        document.getElementById("notworking").onclick=(e)=>{
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "php/notworking.php", true);
            xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);
                    document.getElementById("reportarea").innerHTML=data;
                    if(data.length>200)
                    {
                            document.getElementById("okaybutton").style.display="block";
                    }
                    }
                }
            }
            let formData = new FormData(form);
            xhr.send(formData);
        }

        document.getElementById("disposed").onclick=(e)=>{
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "php/disposed.php", true);
            xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);
                    document.getElementById("reportarea").innerHTML=data;
                    if(data.length>200)
                    {
                            document.getElementById("okaybutton").style.display="block";
                    }
                    }
                }
            }
            let formData = new FormData(form);
            xhr.send(formData);
        }
    
     document.getElementById("invoicechkbox").onclick=()=>{
        alert('Here');
        if(document.getElementById("invoicecheck").value=="uncheck")
        {
            document.getElementById("areabasedoncheck").innerHTML='<div class="col-md-5"></div><div class="col-md-2"><input type="text" class="form-control" id="invoice" name="invoice" placeholder="Invoice Number" required></div>';
            document.getElementById("invoicecheck").value="check";
        }
        else
        {
            document.getElementById("invoicecheck").value="uncheck";
            document.getElementById("areabasedoncheck").innerHTML='<div class="col-md-3"></div><div class="col-md-1"><label for="inputEmail3" class="col-md-5 control-label">From</label></div><div class="col-md-2"><input type="date" class="form-control" id="from" name="from" placeholder="From Date" required></div><div class="col-md-1"><label for="inputEmail3" class="col-md-5 control-label">To</label></div><div class="col-md-2"><input type="date" class="form-control" id="to" name="to" placeholder="To Date" required></div>';
        }   
    }
	
	document.getElementById("labreportbtn").onclick=(e)=>
	{
	e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/labreport.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
	          let data = xhr.response;
	          document.getElementById("reportarea").innerHTML=data;
              if(data.length>200)
              {
                    document.getElementById("okaybutton").style.display="block";
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

    document.getElementById("invoicebtn").onclick=(e)=>{
        alert('here');
        e.preventDefault();
        let xhr=new XMLHttpRequest();
        xhr.open("POST","php/invoicereport.php",true);
        xhr.onload=()=>{
            if(xhr.readyState==XMLHttpRequest.DONE){
                if(xhr.status===200)
                {
                    let data=xhr.response;
                    document.getElementById("reportarea").innerHTML=data;
                    document.getElementById("okaybutton").style.display="block";
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }

    document.getElementById("okaybtn").onclick=()=>{
        location.href="generatereport.php";
    }

</script>
</body>
</html>