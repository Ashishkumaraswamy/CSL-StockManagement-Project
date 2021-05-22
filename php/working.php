<?php
	include_once("config.php");
	session_start();
	

    $locationsql=mysqli_query($conn,"SELECT * FROM category");
    $output="";
    if($locationsql){
        $output.='  <div class="row">
                        <div class="col-sm-offset-2 col-md-9 text-center">';
        
        
        while($row = mysqli_fetch_array($locationsql)) 
        {
            if($row['category_code']!= "mac" and $row['category_code']!= "cpu" and $row['category_code']!= "lap" and $row['category_code']!= "ser"){
                $code = $row['category_code'];
                $sql = mysqli_query($conn,"SELECT * FROM components where componentid like '$code%' and status = 1");
                $idsql = mysqli_query($conn,"SELECT count(*) as count FROM components where componentid like '$code%' and status = 1");
                $lab = mysqli_fetch_assoc($idsql);
                if(mysqli_num_rows($sql)>0)
                {
                    $output.='
                            <table class="table table-hover">
                            <caption><center><h4 class="text-center"><b>'.$row['category'].' working count : '.$lab['count'].' </b></h4></center></caption>
                                <tr>
                                <th>Component ID</th>
                                <th>Description</th>
                                <th>Location</th>
                                </tr>';
                    while($labsys = mysqli_fetch_assoc($sql))
                    {
                        $c = $labsys['location'];
                        $loc = mysqli_query($conn,"SELECT * FROM location where lab_id = $c ");
                        $location = mysqli_fetch_assoc($loc);

                        $output .='<tr>
                            <td>'.$labsys['componentid'].'</td>
                            <td>'.$labsys['brand'].','.$labsys['type'].','.$labsys['description'].'</td>
                            <td>'.$location['lab_name'].'</td>
                            </tr>';
                    }

                    $output .='</table> <br><br><br>';
                }
                else{
                    // $output.='<caption><center><h4 class="text-center"><b>'.$row['category'].' working fine.</b></h4></center></caption>
                    // <br><br><br>';
                }

            }else{
                $code = $row['category_code'];
                
                $sql=mysqli_query($conn,"SELECT * FROM cpu where cpu_id like '$code%' and status = 1");
                $idsql = mysqli_query($conn,"SELECT count(*) as count FROM cpu where cpu_id like '$code%' and status = 1");
                $lab = mysqli_fetch_assoc($idsql);

                
                if(mysqli_num_rows($sql)>0)
                {
                    
                    $output.=' 
                            <table class="table table-hover">
                            <caption><center><h4 class="text-center"><b>'.$row['category'].' working count : '.$lab['count'].' </b></h4></center></caption>
                                <tr>
                                <th>Component ID</th>
                                <th>Description</th>
                                <th>Location</th>
                                </tr>';
                    while($labsys=mysqli_fetch_assoc($sql))
                    {
                        $c = $labsys['location'];
                        $loc = mysqli_query($conn,"SELECT * FROM location where lab_id = $c ");
                        $location = mysqli_fetch_assoc($loc);

                        $output .='<tr>
                            <td>'.$labsys['cpu_id'].'</td>
                            <td>'.$labsys['RAM'].','.$labsys['processor_series'].','.$labsys['storage'].','.$labsys['description'].'</td>
                            <td>'.$location['lab_name'].'</td>
                            </tr>';
                    }	

                    $output .='</table> <br><br><br>';

                }
                else{
                    // $output.='<caption><center><h4 class="text-center"><b>'.$row['category'].' working fine.</b></h4></center></caption>
                    // <br><br><br>';
                }
               
            }

        }
    }
    else{
        echo '<div class="alert alert-info">
        <strong>Category sql failure</strong> 
        </div>';
    }
    $output .='</div>';
    echo $output;
	
?>