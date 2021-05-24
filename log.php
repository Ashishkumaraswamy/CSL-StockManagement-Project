<?php
    include_once("navigation.php");
?>
<center><h2>VIEW LOG HISTORY</h2></center>

<center><form action="" class="form-horizontal" method="post" name="myForm" id="formlog">
<br>
                
                    <div class="col-4">
                    </div>
                    <div class="col-md-2">
                    <input type="text" class="form-control" id="searchname" name="searchname" placeholder="ComponentID/CPU-ID">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="actio" name="actio" placeholder="Purpose">
                    </div>
                    <label for="inputEmail3" class="col-md-1 control-label">From</label>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="from" name="from" placeholder="From Date" required>
                    </div>
                    <label for="inputEmail3" class="col-md-1 control-label">To</label>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="to" name="to" placeholder="To Date" required>
                    </div>
                    
                        <button type="submit" class="btn btn-primary" id="searchareabtn" name="goo">Search </button>
                    
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="loader" id="load"></div>

                    <div class="form-group" id="reportarea">
                    
                    
                    </div>
            
          
			</form></center><br><br><br>

<?php
    include_once("footer.php");
?>
<script>

    const form= document.querySelector("#formlog");

    let xhr=new XMLHttpRequest();
    xhr.open("POST","php/log.php",true);
    xhr.onload=()=>{
        if(xhr.readyState==XMLHttpRequest.DONE){
            if(xhr.status===200)
            {
                document.getElementById("load").style.display="none";
                let data=xhr.response;
                console.log(data);
                document.getElementById("reportarea").innerHTML=data;
                document.getElementById("reportarea").style.display="block";
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);


    document.getElementById("searchareabtn").onclick=(e)=>
    {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/searchlog.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status===200)
            {
                
                let data=xhr.response;
                console.log(data);
                document.getElementById("reportarea").innerHTML=data;
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
    }


</script>	
</body>
</html>
