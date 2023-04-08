<?php
$login = false;
$showError = false;
include 'partials/_dbconnect.php';
// $registered = $_GET['registered'];
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
 
  $Email = $_POST["Email"];
  $Password = $_POST["Password"];

  //Admin  login
  // if($username=='admin@gmail.com' && $password=='admin@gmail.com'){
  //   echo "Admin";
  //   header("location: admin.php");
  // }

  $exists = false;
  $admin = false;
 
  $sql = "SELECT * FROM `users` WHERE Email='$Email'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if($num == 1){
    while($row = mysqli_fetch_assoc($result)){
      //Admin Login
      if($Password==$row['Password']){
        session_start();
        $_SESSION['adminloggedin'] = true;
        $_SESSION['issueupdated'] = false;
        $admin = true;
        header("location: admin.php");
      }
      // Verifying password
      else if(password_verify($Password, $row['Password'])){
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $registered = false;
        // fetching name of the user form database
        $nameQuery = mysqli_query($conn, "SELECT name FROM `users` WHERE Email='$Email'");
        $fetchName = mysqli_fetch_array($nameQuery);
        $Name = $fetchName["Name"];
        

        $_SESSION['Email'] = $Email;

        header("location: homepage.php");
      }
      else{
        $showError = "Invalid Credentials";
      }
    }
  }
  else{
    $showError = "Invalid Credentials";
  }
}
?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login - DUCC Sahaay</title>
   
    <!-- Linking External CSS  -->
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
    <?php require 'partials/_nav.php' ?>

    <?php
    // if($registered){
    //   echo '<div class="container mt-4">
    //           <div class="row">
    //             <div class="col-lg-2"></div>
    //             <div class="col-lg-8">
    //               <div class="alert alert-success alert-dismissible fade show" role="alert">
    //                 <strong>Success! </strong>You can login now.
    //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                     <span aria-hidden="true">&times;</span>
    //                 </button> 
    //               </div>
    //             </div>
    //           <div class="col-lg-2"></div>
    //         </div>
    //       </div>';
    //   }

    if($login){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success! </strong>You are logged in!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button> 
        </div>';
    }
    if($showError){     
      echo '<div class="container mt-4">
                <div class="row">
                  <div class="col-lg-2"></div>
                  <div class="col-lg-8">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error! </strong>'.$showError.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button> 
                    </div>
                  </div>
                <div class="col-lg-2"></div>
              </div>
            </div>';
  }
    ?>

    <!-- Main Container -->
    <div class="container-fluid ">
        <div class="row">
            <div class="col-lg-4 "></div>
            <div class="col-lg-4 my-5 text-center ">
                <!-- DUCC Logo -->
                <div class="row">
                    <div class="col-12">
                        <img src="images/ducclogo.png" alt="ducclogo">
                    </div>
                </div>
                
                <div class="row my-5 mx-3">
                    <div class="col-12">
                        <form action="index.php" method="post">
                            <!-- Email Button -->
                            <div class="form-group">
                              <label for="Email">Email</label>
                              <input type="email" class="form-control" id="Email" name="Email" aria-describedby="emailHelp" placeholder="Enter your DU email">
                            
                            </div>
                            <!-- Password Button -->
                            <div class="form-group">
                              <label for="Password">Password</label>
                              <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
                            </div>
                            <!-- Login Button -->
                           <div class="d-flex justify-content-center">
                                <button type="submit" id="loginbtn" class="btn btn-primary btn-lg btn-block my-2 text-center" style="background: rgb(148, 45, 161); width: 80%;">LOGIN</button>
                            </div>
                            <p>OR</p>
                            <!-- Register Button -->
                            <div class="d-flex justify-content-center">
                                <button type="button" onclick="window.open('register.php','_self');" id="registerbtn" class="btn btn-primary btn-lg btn-block my-2 text-center" style="background: rgb(148, 45, 161); width: 80%;">REGISTER</button>
                            </div>
                          </form>
                    </div>
                </div>
                
                <!-- <div class="row">
                    <div class="col-12"></div>
                </div> -->

            </div>
            <div class="col-lg-4 "></div>
        </div>
    </div>
    <!-- Footer -->
    <div class="container-fluid" 
          style="position: fixed;
                text-align: center;
                padding: 10px 10px 0px 10px;
                bottom: 0;
                width: 100%;
                height: 40px;
                color: rgb(255, 255, 255);
                background-color: rgb(148, 45, 161)
                ">
      <div class="row">
        <div class="col">
          <p style="font-size:15px;"> © 2023 Copyright: DUCC Sahaay</p>
        </div>
      </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    
  </body>
</html>