<?php
    include_once("navigation.php");
?>
<center><h2>NEW PURCHASE ENTRY</h2></center>

<center><form action="" class="form-horizontal" method="post" onsubmit="return validateForm()" name="myForm">	  
<br>
<div class="form-group pt-2">
            <label for="inputEmail3" class="col-md-5 control-label">Invoice Number</label>
            <div class="col-md-3">
              <input type="text" class="form-control" id="p1" name="p1" placeholder="Invoice Number" required>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-md-5 control-label">Purchase Details</label>
            <div class="col-md-3" style="margin:black">
              	
            </div>
          </div>
          <div class="form-group">
          	<h4 class="text-center"> Add Components</h4>
          	<div class="row">
          		<div class="col-md-4">
	            	<label for="components" class="col-md-9 control-label">Category:</label>
	            	<div class="dropdown">
					    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Category
					    <span class="caret"></span></button>
					    <ul class="dropdown-menu">
					      <?php
					      		$categorysql=mysqli_query($conn,"SELECT * FROM category");
					      		$output ="";
					      		while($category=mysqli_fetch_assoc($categorysql))
					      		{
					      			$output.='<li><a href="#">'.$category['category'].'</a></li>';
					      		}
					      		echo $output;
					      ?>
					    </ul>
				    </div>
	        	</div>
	        	<div class="col-md-4">
	        		<input id="brand" type="text" class="form-control-inline" name="brand" placeholder="Brand">
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
</body>
</html>
