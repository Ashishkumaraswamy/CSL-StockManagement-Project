<html>

<head>
    <title>CSL StockManager</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="images/csl_logo.png">
    <style>

div.color_white{
    color:white;
}
div.picture {
    background-image: url("images/labimg2png.png");
    min-height: 300px;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    background-color: white;
    opacity: 0.5;
}
div.padding{
    padding-top : 122px;
    padding-bottom : 122px;
    padding-left : 480px;
    padding-right : 480px;
    color : white;
}
div.transbox {
  margin-top: 10%;
  margin-left: 40%;
  margin-right: 40%;
  margin-bottom: 15%;
  background-color: black;
  opacity : 0.8;
  border: 0px solid black;
  padding:10px;
}
div.transbox p {
  margin: 5%;
  font-weight: bold;
  color: white;
}

.error-text{
    font-family: Poppins-Regular;
    background: #ffcccb;
    display :block;
    border-radius: 5px;
    line-height: 2.5;
    text-align: center;
}
</style>
</head>
<script>
function doHash(str){
    len = str.length;

    hash = 0;
    for(i=1; i<=len; i++){
        char = str.charCodeAt((i-1));
        hash += char*Math.pow(31,(len-i));
        hash = hash & hash; //javascript limitation to force to 32 bits
    }

    return hash;
}
function dosecurity(){
    document.getElementById("p2").value = doHash(document.getElementById("p2").value);
    
}
</script>
<body>
    <div class="container-fluid color_blue">
        <div class="row text-center">
            <div class="col-md-2 pos">
                <img src="images/psg_logo.png">
            </div>
            <div class="col-md-8">
                <h2>PSG College of Technology</h2>
                <h4>Applied Mathematics and Computational Sciences Laboratories</h4>
                <h4>CSL StockManager</h4>
            </div>
            <div class="col-md-2">
                <img src="images/csl_logo.png" width="150px" height="120px">
            </div>
        </div>
    </div>
    <div class="picture">
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-md-12">
                    <div class="transbox">
                        <h3 class="text-center color_white">AMCS LAB</h3>
                    <form class="form-signin" action="php/login.php" method="post" id="loginform">
                        <div class="error-text"></div>
                        <h4 class="text-left color_white">Roll No</h4>
                        <input type="name" name="username" id="username" class="form-control" placeholder="Roll No" required autofocus>
                        <h4 class="text-left color_white">Password</h4>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        <br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="dosecurity()" name="add" id="add">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 color_blue padding_footer">
                <h4>Developed and Maintained by Softies2k15</h4>
            </div>
            <div class="col-md-6 color_blue text-right padding_footer">
                <h4>Copyright <i class="fa fa-copyright" aria-hidden="true"></i> CSL. All rights reserved</h4>
        </div>
    </div>
<script type="text/javascript">
    const form = document.querySelector("#loginform"),
continueBtn = form.querySelector("#add"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "success"){
                location.href = "mainpage.php";
              }else{
                errorText.style.display = "block";
                errorText.textContent = data;
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
</script>
</body>

</html>