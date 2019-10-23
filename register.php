<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (isset($_SESSION['loggedin'])) {
	header('Location: home.php');
	exit();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link href="registerstyle.css" rel="stylesheet" type="text/css">

</head>
<body>


<div class="signhead">
        <h2>Choose Member Type to Register..</h2>
<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Member Sign Up</button>
<button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Organization Sign Up</button>
<button onclick="document.getElementById('id03').style.display='block'" style="width:auto;">School Sign Up</button><hr>
<p>To Go Back: <a href="index.php">Click Here</a></p>
</div>	

<!----------------------------------------------Individual-------------------------------------------------------------------->
<div id="id01" class="modal">


        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form class="modal-content"  method="post" action="individualR.php">
	 <div class="container">
		 <h1>Individual Member Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
   <div>
            <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

  <label for="title"><b>Title</b></label>
      <input type="text" placeholder="Example: Mr or Mrs" name="title" required>
      
      <label for="firstname"><b>Firstname</b></label>
      <input type="text" placeholder="Enter Firstname" name="firstname" required>
	  
	  <label for="lastname"><b>Lastname</b></label>
      <input type="text" placeholder="Enter Lastname" name="lastname" required>
      
      <label for="dob"><b>Date of Birth</b></label>
      <input type="date" placeholder="" name="dob" ><br><br>
      
      <label for="phonenum"><b>Phone Number</b></label>
      <input type="text" placeholder="Example: 021253456" name="phonenum" required>
      
	  <label><b> Address</b></label><br>
	    <input type="street" 
         class="form-control" 
         placeholder="Street"
		 name="street">
  
  <input type="city" 
         class="form-control" 
         placeholder="City"
		 name="city">
  
  <input type="zip" 
         class="form-control" 
         placeholder="Zip"
		 name="zip">
  
  <input type="country" 
         class="form-control" 
         placeholder="Country"
		 name="country"><br><br>


	  
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>
	
                 <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
      
      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
	  
<div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
			</div>
        </form>
    </div>  
</div>
  

<!----------------------------------------------Organisation------------------------------------------------------------------------>
<div id="id02" class="modal">

    <div>
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
         <form class="modal-content" method="post" action="organisationR.php">
		<div class="container">
		 <h1>Organisation Member Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
            <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

   <label for="username"><b>Organization Name</b></label>
      <input type="text" placeholder="Enter Organisation Name" name="org_name" required>
      
      <label for="phonenum"><b>Phone Number</b></label>
      <input type="text" placeholder="Example: 021253456" name="phonenum" required>
      
	  <label><b> Address</b></label><br>
	    <input type="street" 
         class="form-control" 
         placeholder="Street"
		 name="street">
  
  <input type="city" 
         class="form-control" 
         placeholder="City"
		 name="city">
  
  <input type="zip" 
         class="form-control" 
         placeholder="Zip"
		 name="zip">
  
  <input type="country" 
         class="form-control" 
         placeholder="Country"
		 name="country"><br><br>
	  
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>
	
                 <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
      
      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
<div class="clearfix">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
			</div>
        </form>
    </div>  
</div>	

<!----------------------------------------------School------------------------------------------------------------------>
<div id="id03" class="modal">

    <div>
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
         <form class="modal-content"  method="post" action="schoolR.php">
		<div class="container">
		 <h1>School Member Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
            <label for="username"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label for="username"><b>School Name</b></label>
      <input type="text" placeholder="Enter School Name" name="sname" required>
      
      <label for="phonenum"><b>Phone Number</b></label>
      <input type="text" placeholder="Example: 021253456" name="phonenum" required>
      
	  <label><b> Address</b></label><br>
	    <input type="street" 
         class="form-control" 
         placeholder="Street"
		 name="street">
		 
   <input type="suburb" 
         class="form-control" 
         placeholder="Suburb"
		 name="suburb">
  
  <input type="city" 
         class="form-control" 
         placeholder="City"
		 name="city">
  
  <input type="country" 
         class="form-control" 
         placeholder="Country"
		 name="country"><br><br>
	  
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>
	
                 <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
      
      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
<div class="clearfix">
        <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
            <p>Already have an account? <a href="index.php">Login here</a>.</p>
			</div>
        </form>
    </div>  
</div>	
</body>
</html>