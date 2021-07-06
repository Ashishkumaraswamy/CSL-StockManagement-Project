<?php
    include_once("navigation.php");
?>
<center><form action="" class="form-horizontal" method="post" name="myForm" id="formassign">
<br><br>
            <div class="col-md-2">
            </div>
            <div class="col-md-2">
            <div class="radio">
              <label style="font-size: 15px"><input type="radio" name="reporttype" id="Search">Searchwise Report</label>
            </div>
            </div>
            <div class="col-md-2">
            <div class="radio">
                <label style="font-size: 15px"><input type="radio" id="overall" name="reporttype">Invoice  Report</label>
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
          <br>
          <br>
          <br>
                <input type="text" name="invoicecheck" id="invoicecheck" value="uncheck" hidden>
                <div class="form-group" id="overallarea" hidden>
                        <center><h4 class="text-center"><b>Invoice Report</b></h4></center>
                        <br><br>
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-3">
                            <div class="radio">
                              <label style="font-size: 15px"><input type="radio" name="invreporttype" id="datewise">Datewise Report</label>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="radio">
                                <label style="font-size: 15px"><input type="radio" id="alltype" name="invreporttype">Get All Invoice Report</label>
                            </div>
                            </div>
                            <div class="col-md-2">
                            <div class="radio">
                              <label style="font-size: 15px"><input type="radio" name="invreporttype" id="idwise">Get Report by ID</label>
                            </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div id="areabasedoncheck">
                            
                        </div>
                </div>

                <div class="form-group" id="Searcharea" hidden>
                        <center><h4 class="text-center"><b>Searchwise Report</b></h4></center>
                        <br><br>

                        <div class="col-md-4">
                        </div>
                        <div class="col-md-3">
	        		    <input type="text" class="form-control" id="searchname" name="searchname" placeholder="ComponentID/CPU-ID">
	        	        </div>


                        <div class="col-md-1">
                        <button type="submit" class="btn btn-primary" id="searchareabtn" name="goo">Search </button>
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
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary" id="btnExport">Download</button>
                    </div>
                    
                </div>
                <div id="elementH"></div>

            </form></center><br><br><br>


<?php
    include_once("footer.php");
?>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/jsPDF/dist/jspdf.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js""></script>
<script>
    // document.getElementById("btnExport").onclick=(e)=>{
    // var pdf = new jsPDF('p', 'pt', 'letter');
    // pdf.fromHTML(document.getElementById("main"));
    // pdf.save('test.pdf');
    // };
    // $("body").on("click", "#btnExport", function (event) {
    //     // $("#logo").css("display", "block");
    //         event.preventDefault();
    //         html2canvas($('#reportarea') ,{
    //             onrendered: function (canvas) {
    //                 var data1 = canvas.toDataURL();
    //                 var docDefinition = {
    //                     pageSize: 'A4',
    //                     margin:[ 10, 10, 10, 10 ],
    //                     startPosition: {
    //                         left: 5,
    //                     },
    //                     content: [
    //                         {
    //                         image: data1,
    //                         width: 500,
    //                     }]
    //                 };
                
    //                 pdfMake.createPdf(docDefinition).download("report.pdf");
    //             }
    //         });
    // });
    document.getElementById("btnExport").onclick=(e)=>{
            e.preventDefault();
            n =  new Date();
            y = n.getFullYear();
            m = n.getMonth() + 1;
            d = n.getDate();
            var dateprint = d + "/" + m + "/" + y;
            var divContents = $("#reportarea").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title></title></head>');
            printWindow.document.write('<body style="width:100%;position:relative"><center><div class="container-fluid color_blue" id="logo" style="position:relative;"><div class="row text-center"><div class="col-md-8"><h2>PSG College of Technology</h2><h4>Applied Mathematics and Computational Sciences Laboratories</h4><h4>CSL Stock Report</h4></div></div></div></center><br><br>');
            printWindow.document.write('<h4>Date :'+dateprint+'</h4>');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
    }
    const form= document.querySelector("#formassign");

    document.getElementById("overall").onclick=(e)=>{
        // document.getElementById("status").style.display="none";
        document.getElementById("statusarea").style.display="none";
        document.getElementById("labwisearea").style.display="none";
        document.getElementById("okaybutton").style.display="none";
        document.getElementById("Searcharea").style.display="none";
        document.getElementById("overallarea").style.display="block";
    }

    document.getElementById("status").onclick=(e)=>{
        // document.getElementById("overall").style.display="none";
        document.getElementById("overallarea").style.display="none";
        document.getElementById("labwisearea").style.display="none";
        document.getElementById("okaybutton").style.display="none";
        document.getElementById("Searcharea").style.display="none";
        document.getElementById("statusarea").style.display="block";

    }
    document.getElementById("labwise").onclick=(e)=>{
        //document.getElementById("radiovalue").value="labwise";
        document.getElementById("overallarea").style.display="none";
        document.getElementById("statusarea").style.display="none";
        document.getElementById("okaybutton").style.display="none";
        document.getElementById("Searcharea").style.display="none";
        document.getElementById("labwisearea").style.display="block";
    }
    document.getElementById("Search").onclick=(e)=>{
        //document.getElementById("radiovalue").value="labwise";
        document.getElementById("overallarea").style.display="none";
        document.getElementById("statusarea").style.display="none";
        document.getElementById("okaybutton").style.display="none";
        document.getElementById("labwisearea").style.display="none";
        document.getElementById("Searcharea").style.display="block";
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

    document.getElementById("datewise").onclick=()=>{
        document.getElementById("reportarea").innerHTML="";
        document.getElementById("areabasedoncheck").innerHTML='<div class="col-md-3"></div><div class="col-md-1"><label for="inputEmail3" class="col-md-5 control-label">From</label></div><div class="col-md-2"><input type="date" class="form-control" id="from" name="from" placeholder="From Date" required></div><div class="col-md-1"><label for="inputEmail3" class="col-md-5 control-label">To</label></div><div class="col-md-2"><input type="date" class="form-control" id="to" name="to" placeholder="To Date" required></div><div class="col-md-1"><button type="submit" class="btn btn-primary" id="datewisebtn" name="goo">Go</button></div>';
    }

    document.getElementById("idwise").onclick=()=>{
        document.getElementById("reportarea").innerHTML="";
        document.getElementById("areabasedoncheck").innerHTML='<div class="col-md-5"></div><div class="col-md-2"><input type="text" class="form-control" id="invoice" name="invoice" placeholder="Invoice Number" required></div><div class="col-md-1"><button type="submit" class="btn btn-primary" id="idwisebtn" name="goo">Go</button></div>';
    }
    
    document.getElementById("alltype").onclick=(e)=>{
        document.getElementById("areabasedoncheck").innerHTML="";
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/allinvoicereport.php", true);
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
                      alert('No data found');
                  }
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);  
    }

    $(document).on('click','#datewisebtn',function(e){
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/datewisereport.php", true);
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
                alert('No data found');
              }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
    });

    $(document).on('click','#idwisebtn',function(e){
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/idwisereport.php", true);
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
                alert('Invoice Id does not exist');
              }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
    });
    
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
                alert('No data found');
              }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
    }

    document.getElementById("searchareabtn").onclick=(e)=>
    {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/search.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status===200)
            {
                let data=xhr.response;
                console.log(data);
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