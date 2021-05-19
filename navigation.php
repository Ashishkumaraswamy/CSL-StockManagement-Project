<?php
    session_start();
    include_once("php/config.php");
    $usersql=mysqli_query($conn,"SELECT * FROM users WHERE user_id={$_SESSION['unique_id']}");
    $user=mysqli_fetch_assoc($usersql);
?>

<html>

<head>
    <title>CSL Stock Manager</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="images/csl_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    .dropbtn {
    background-color: #337ab7;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}
    .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }
    .padding{
        padding-top: 375;
    }
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {
        background-color: #f1f1f1
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    .dropdown:hover .dropbtn {
        background-color: #143049;
    }
</style>
</head>
<body>
    <div class="container-fluid color_blue">
        <div class="row text-center">
            <div class="col-md-2 pos">
                <img src="images/psg_logo.png">
            </div>
            <div class="col-md-8">
                <h2>PSG College of Technology</h2>
                <h4>Applied Mathematics and Computational Sciences Laboratories</h4>
                <h4>CSL Stock Manager</h4>
            </div>
            <div class="col-md-2">
                <img src="images/csl_logo.png" width="150px" height="120px">
            </div>
        </div>
    </div>
    <div class="container-fluid color_blue">
        <div class="row">
            <div class="col-md-6">
                <h4 id="date"></h4>
            </div>
            <div class="col-md-6 text-right" id="border1">
                <h4>Welcome : <?php echo ''.$user['user_name'].''?>| <a href="index.php"  style="color:white">SignOut</a></h4>
            </div>
        </div>
    </div>
    <div class="container-fluid color_blue">
        <div class="row text-center">
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="dropbtn"> Profile <i class="fa fa-caret-down fa-lg"></i></button>
                    <div class="dropdown-content text-left">
                        <a href="change_password.php">Change Password</a>
                        <a href="update_profile.php">Update Profile</a>
                        <a href="view_profile.php">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="dropbtn"> Actions <i class="fa fa-caret-down fa-lg"></i></button>
                    <div class="dropdown-content text-left">
                        <a href="addpurchase.php">Add new Purchase</a>
                        <a href="viewentry.php">Assign Components</a>
                        <a href="">View Log</a>
                        <a href="">Add location</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="dropbtn"> Report <i class="fa fa-caret-down fa-lg"></i></button>
                    <div class="dropdown-content text-left">
                    <a href="csltedtalk.php">Generate Report</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
               <div class="dropdown">
                <button class="dropbtn"> System Complaints <i class="fa fa-caret-down fa-lg"></i></button>
                    <div class="dropdown-content text-left">
                    <a href="systemComplaints.php">Register Complaint</a>
                    <a href="viewSystemComplaints.php">View Complaint</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    var date=new Date();
    document.getElementById("date").innerHTML="Date: "+date.getDate()+"-"+(date.getMonth()+1)+"-"+date.getFullYear();
</script>
