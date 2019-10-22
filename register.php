
<?php 
include("connection.php");
// setting the errors;
$userError="";
$passwordError="";
$password2Error="";
$fnameError="";
$lstnameError="";
$affiliateError="";
$emailError="";
$email2Error="";
$phoneError="";
$stateError="";
$urlError="";
$genderError="";
$imageError="";
// if it set;
if(isset($_POST["submit"])){

// validating the form datas.
if(strlen($_POST["username"])<5){
  $userError="minimum of 5 letters is required";
}
else{
  $Username=myFunction($_POST["username"]);
}

if(strlen($_POST["password"])<5){
  $passwordError="Weak password, minimum of 5 letters is required";
}
else{
  $Password=myFunction($_POST["password"]);
}

if($_POST["confpassword"] !== $_POST["password"]){
  $password2Error="Password Do Not Match";
}
else{
  $Confpassword=myFunction($_POST["confpassword"]);
}

//using regular expression for validation

if(!preg_match("/^[a-zA-Z .]*$/",$_POST['firstname'])){
  $fnameError = "only letters and whitespace can be accepted";

}
elseif(!preg_match("/^[a-zA-Z .]*$/",$_POST['lastname'])){
  $lstnameError = "only letters and whitespace can be accepted";
 
}
else{
  $Firstname=myFunction($_POST["firstname"]);
  $Lastname=myFunction($_POST["lastname"]);

}
 
  //email
  if(!preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/",$_POST['email'])){
    $emailError = "Invalid Email format";
}
  elseif($_POST['email'] !== $_POST['confemail']){
    $email2Error="Email Do Not Match";
  }
  else{
    $Email=myFunction($_POST["email"]);
    $Confemail=myFunction($_POST["confemail"]);
  }
 

  if(empty($_POST['url'])){
 $urlError = "Url is Required";
  }
  else{
      $Url = myFunction($_POST['url']);
      if(!preg_match("/(https:|(ftp:))\/\/+[a-zA-Z0-9.\-_\&$=\#\/?\~`!]+\.[a-zA-Z0-9.\-_\&$=\#\/?\~`!]*/",$_POST['url'])){
          $urlError = "Invalid url";
      }
  }
  if(empty($_POST['affiliate'])){
    $affiliateError="Please Type your Institution";
  }
  else{
    $Affiliation=myFunction($_POST['affiliate']);
  }
 if(empty($_POST['gender'])){
   $genderError="Gender is required";
 }
 else{
   $Gender=myFunction($_POST['gender']);
 }
 if(empty($_POST['state'])){
   $stateError="please input your Location";
 }
 else{
   $State=myFunction($_POST['state']);
 }
 if(empty($_POST['phone'])){
   $phoneError="Phone is required";
 }
 else{
   $Phone=myFunction($_POST['phone']);
 }

$Username=mysqli_real_escape_string($connection,$_POST["username"]);
$Password=mysqli_real_escape_string($connection,$_POST["password"]);
$Confpassword=mysqli_real_escape_string($connection,$_POST["confpassword"]);
$Salutation=mysqli_real_escape_string($connection,$_POST["salutation"]);
$Fname=mysqli_real_escape_string($connection,$_POST["firstname"]);
$Midname=mysqli_real_escape_string($connection,$_POST["midname"]);
$Lstname=mysqli_real_escape_string($connection,$_POST["lastname"]);
$Affiliation=mysqli_real_escape_string($connection,$_POST["affiliate"]);
$Email=mysqli_real_escape_string($connection,$_POST["email"]);
$Confemail=mysqli_real_escape_string($connection,$_POST["confemail"]);
$Url=mysqli_real_escape_string($connection,$_POST["url"]);
$Phone=mysqli_real_escape_string($connection,$_POST["phone"]);
$Fax=mysqli_real_escape_string($connection,$_POST["fax"]);
$State=mysqli_real_escape_string($connection,$_POST["state"]);
$Gender=mysqli_real_escape_string($connection,$_POST["gender"]);

$Image=$_FILES["image"]["name"];
$Img_user="userimg/".basename($Image);
$sig_img=$_FILES["signature"]["name"];
$sign = "signature/".basename($sig_img);
$Vkey = md5(time().rand(1,30));// this will generate a verification for the user;
echo $Vkey;
if(!empty($Username) && !empty($Password) && !empty($Fname) && !empty($Email) && !empty($Url) && !empty($Phone) && !empty($Image)){
global $connection;
$insert="INSERT INTO register(username,password,salutation,firstname,midname,lastname,gender,
      affiliate,email,url,signature,phone,vkey,state,image) VALUES('$Username','$Password','$Salutation','$Firstname','$Midname',
      '$Lstname','$Gender','$Affiliation','$Email','$Url','$sig_img','$Phone','$Vkey','$State','$Image')";

$Query=mysqli_query($connection,$insert);
move_uploaded_file($_FILES["image"]["name"],$Img_user);
move_uploaded_file($_FILES["signature"]["name"],$sign);
if($Query){
   //send email;
  //  $to = $Email;
  //  $subject = "Email Verification";
    //$message = "<a href='http://localhost/reserach/verification.php?vkey=$Vkey'>Verify Account</a>";
  //  $header="From: charity.jv.jvo@gmail.com \r\n";
  //  $header.="MIME-Version: 1.0" . "\r\n";
  //  $header.="Content-type:text/html;charset=UTF-8". "\r\n";
  //  mail($to,$subject,$message,$header);
   // echo "<script>alert(\"<a href='http://localhost/reserach/verification.php?vkey=$Vkey'>Verify Account</a>\")</script>";

  //  header("location:thankyou.php");
}
else{
  die(mysqli_error($connection));
}
}// not empty statement closed tag
else{
  echo "Please fill the Required field";
}

}







// creating my own function;
function myFunction($data){
  return $data;
}



?>
<!DOCTYPE html>
<html>
<head>
	<title>wyd</title>
	<meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    
	<link rel="stylesheet" type="text/css" href="css/style.css">
	
</head>

<body>
	
<div>
<div class="row loginpage"><div id="login" class="col-sm-6"><a href="#" >
        <img src="image/unilag.png" height="35" alt="CoolBrand" class="ml-5 my-2">
    </a></div>
    
        <div class="col-sm-6">
            <div class="row my-2">
                <div class="col-sm-5">
       Username <input class="username" type="text"  aria-label="Search"></div>
       <div class="col-sm-7">
       Password <input class="username" type="password"> <button type="submit" class="btn btn-success pb-4" name="login" id="login">Login</button><p class="text-center text-danger"><a href="register.php"><i style="color:black;">New User?</i>  Register</a></p>
</div>
<!--
<div class="col-sm-2 ">
   <span class="glyphicon glyphicon-arrow-right"></span>
</div>
-->


</div>

</div>
   </div>
    
 <nav class="navbar navbar-expand-md bg-cus">
    
  
     <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ml-4">
            <a href="index.php" class="nav-item nav-link active pl-4">Home</a>
            <a href="about.php" class="nav-item nav-link pl-5">About</a>
            <a href="submission.php" class="nav-item nav-link pl-5">Submission</a>
            <a href="current.php" class="nav-item nav-link pl-5">Current</a>
            <a href="archive.php" class="nav-item nav-link px-5" tabindex="-1">Archive</a>
        </div>
         <div class="navbar-nav ml-auto">
            <!-- <a href="login.php" class="nav-item nav-link">Login</a>
            <a href="register.php" class="nav-item nav-link">Register</a> -->
            <input class="form-control mr-sm-2" type="text"  aria-label="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
</div>
        </div>
   
 </nav>
</div>
</div>

    <div class="fluid-container reg">
        <div class="row">
            <div class="col-md-12 top">
                
                <h5> REGISTER </h5>
            
            </div>
            
        </div>
    </div>

    <div class="container main">
  <form action="register.php" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-25">
        <label for="fname">Username:</label>
      </div>
      <div class="col-75">
        <input type="text" id="usname" name="username">
        <p class="error"><?=$userError;?></p>

      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="lname">Password</label>
      </div>
      <div class="col-75">
        <input type="password" id="pword" name="password">
        <p class="error"><?=$passwordError;?></p>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="pass2">Repeat Password</label>
      </div>
      <div class="col-75">
        <input type="password" id="pword" name="confpassword">
        <p class="error"><?=$password2Error;?></p>

      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="validation">Validation</label>
      </div>
      <div class="col-75">
        <input type="text" id="valid" name="validation">

      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="Salutation">Salutation:</label>
      </div>
      <div class="col-75">
        <input type="text" id="salute" name="salutation">
        
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="fname">First Name:</label>
      </div>
      <div class="col-75">
        <input type="text" id="fname" name="firstname">
        <p class="error"><?=$fnameError;?></p>

      </div>
    </div>

    <div class="row">
      <div  class="col">
        <label for="lname">Middle Name</label>
      </div>
      <div class="col-75">
        <input type="name" id="mname" name="midname">
      </div>
    </div>  

    <div class="row">
      <div class="col-25">
        <label for="lname">Last Name</label>
      </div>
      <div class="col-75">
        <input type="text" id="lname" name="lastname">
        <p class="error"><?=$lstnameError;?></p>

      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="lname">Initials</label>
      </div>
      <div class="col-75">
        <input type="psw" id="pword" name="initial">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="lname">Gender</label>
      </div>
      <div class="col-75">
        <select id="gendertype" name="gender">
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="others">Others</option>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="lname">Affiliation:</label>
      </div>
      <div class="col-75">
        <textarea name="affiliate" rows="3" cols="10">

        </textarea>
        <p class="error"><?=$affiliateError;?></p>

        <p> (Your institution, e.g. "University of Lagos") </p>
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="Signature">Signature:</label>
      </div>
      <div class="col-75">
        <input type="file" id="sign" name="signature" accept="image/png, image/jpeg">
      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="email">Email:</label>
      </div>
      <div class="col-75">
        <input type="email" id="email" name="email">
        <p class="error"><?=$emailError;?></p>

      </div>
    </div>

    <div class="row">
      <div class="col-25">
        <label for="email">Confirm Email</label>
      </div>
      <div class="col-75">
        <input type="email" id="email" name="confemail">
        <p class="error"><?=$email2Error;?></p>

      </div>
    </div>

    

    <div class="row">
      <div class="col-25">
        <label for="url">URL</label>
      </div>
      <div class="col-75">
        <input type="name" id="url" name="url">
        <p class="error"><?=$urlError;?></p>

      </div>
    </div>  

    <div class="row">
      <div class="col-25">
        <label for="phoneNo">Phone</label>
      </div>
      <div class="col-75">
        <input type="number" id="phoneNo" name="phone">
        <p class="error"><?=$phoneError;?></p>

      </div>
    </div>  

    <div class="row">
      <div class="col">
        <label for="fax">Fax</label>
      </div>
      <div class="col-75">
        <input type="number" id="fax" name="fax"  >
      </div>
    </div>    

    <div class="row">
      <div class="col-25">
        <label for="State">Location</label>
      </div>
      <div class="col-75">
        <input type="text" id="state" name="state">
        <p class="error"><?=$stateError;?></p>

      </div>
    </div>  

    <div class="row">
      <div class="col-25">Image
        
      </div>
      <div class="col-75">
        <input type="file" id="image" name="image" placeholder="Upload Image">
        <p class="error"><?=$imageError;?></p>

      </div>
    </div>   

    <div class="row">
      <div class="allowance">
        
      </div>
      <div class="col-75">
        <input type="checkbox" id="image" name="privacy1">
        <label>I agree, to have my data collected and stored according to the privacy statement </label> <br>

        <input type="checkbox" id="" name="check1" >
        <label>I would like to be notified of new publications and announcements </label> <br>
      

        <input type="checkbox" id="image" name="check2" >
        <label>Would you be willing to review submissions to this journal? Yes, request the Reviewer role </label> <br>

        <input type="submit" value="Submit" name="submit" class="btn btn-success">
      </div>
    </div>   

 
    
      
   
  </form>
</div>

<footer>
    <p>Publisher:  Nigeria journal of education science, njes</p>
    <p> For suggestion, recommendationn and possible academic collaboration, feel free to contact our chief editor on contact@njes.com.ng</p>
</footer>




	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/main.js"></script>

</body>

</html>
