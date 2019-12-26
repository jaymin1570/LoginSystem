<?php
session_start();
if (isset($_SESSION['username'])) {
  header("location: welcome.php");
  exit;
}

require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // $user_name=$_POST['username'];

  // check user name is empty ..
  if (empty(trim($_POST["username"]))) {
    $username_err = "Username cannot be blank";
  } else {
    $sql = "select id from users where username = ?"; //prepared query
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "s", $user_name);

      // set the value of param username
      $user_name = trim($_POST['username']);

      // try to execute this statement
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
          $username_err = "This username is already taken ";
        } else {
          $username = trim($_POST['username']);
        }
      } else {
        echo "Something went wromg";
      }
    }
    mysqli_stmt_close($stmt);
  }



  // check for password
  if (empty(trim($_POST['password']))) {
    $password_err = "password cannot be blank";
  } elseif (strlen(trim($_POST['password'])) < 5) {
    $password_err = "password cannot be less than 5 character.";
  } else {
    $password = trim($_POST['password']);
  }


  // check for confirm  password field
  if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
    $confirm_password_err = "password should not match.";
  }
  // If where no error, go ahead and insert into th database

  if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
    $sql = "insert into users (username,password) values(?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

      // set these parameter
      $param_username = $username;
      $param_password = password_hash($password, PASSWORD_DEFAULT);

      // try to execute the query
      if (mysqli_stmt_execute($stmt)) { 
        // <!-- <script type="text/javascript"> alert("successfully registration.....");</script><?php --> 
        header("location:login.php");
      } else {
        echo "Something went wrong .... can not redirect!";
      }
    }
    mysqli_stmt_close($stmt);
  }
  mysqli_close($conn);
}

?>




<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <title>PHP LOGIN SYSTEM!</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Jaymin Makwana</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>


      </ul>

    </div>
  </nav>
  
  <div class="container mt-4 ">
    <h3>Please Register Here</h3>
    <hr>
    <form action="" method="POST" class="needs-validation ">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Username</label>
          <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="username" required>
          <div class="valid-feedback">Valid.</div>
          <div class="invalid-feedback">Please fill out this field.</div>
          <?php if(isset($username_err)){ ?>
          <span style="color:red;"> <?php echo $username_err ?></span>
          <?php } ?>
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Password</label>
          <input type="password" class="form-control" name="password" id="inputPassword4" placeholder="Password" required>
          <div class="valid-feedback">Valid.</div>
    <div class="invalid-feedback">Please fill out this field.</div>
    <?php if(isset($password_err)){ ?>
          <span style="color:red;"> <?php echo $password_err ?></span>
          <?php } ?>
        </div>
      </div>
      <div class="form-group ">
        <label for="inputPassword4">Confirm Password</label>
        <input type="password" class="form-control" name="confirm_password" id="inputPassword" placeholder="Confirm Password" required>
        <div class="valid-feedback">Valid.</div>
    <div class="invalid-feedback">Please fill out this field.</div>
    <?php if(isset($confirm_password_err)){ ?>
          <span style="color:red;"> <?php echo $confirm_password_err ?></span>
          <?php } ?>
      </div>
      <div class="form-group ">
        <label for="inputAddress2">Address 2</label>
        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputCity">City</label>
          <input type="text" class="form-control" id="inputCity">
        </div>
        <div class="form-group col-md-4">
          <label for="inputState">State</label>
          <select id="inputState" class="form-control">
            <option selected>Choose...</option>
            <option>...</option>
          </select>
        </div>
        <div class="form-group col-md-2">
          <label for="inputZip">Zip</label>
          <input type="text" class="form-control" id="inputZip">
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck">
          <label class="form-check-label" for="gridCheck">
            Check me out
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Register</button><br>
      <span>Already Register! <a href="login.php">Login</a>
    </span>
    </form>
  </div>
  

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>