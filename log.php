<?php
    include_once("navigation.php");
?>
<center><h2>VIEW LOG HISTORY</h2></center>

<center><form action="" class="form-horizontal" method="post" name="myForm" id="formlog">
<br>
                <div class="form-group" id="okaybutton">
                    <div class="form-group" id="reportarea">
                    
                    </div>
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
                    let data=xhr.response;
                    console.log(data);
                    document.getElementById("reportarea").innerHTML=data;
                    document.getElementById("reportarea").style.display="block";
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);

</script>	
</body>
</html>
