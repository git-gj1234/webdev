<?PHP

// Start the session
session_start();

// form handler
if($_POST && isset($_POST['name'],$_POST['password'])) {   
    
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "STORE";
    $conn = mysqli_connect($host,$user,$pass,$database);
    if(!$conn){
        die('Could not connect: '.mysqli_connect_error());
    }
    echo 'Connected successfully<br>';    
    
    $name = $_POST['name'];
    $password = $_POST['password'];
    

    if ($name==1 && $password=="122345"){
        $_SESSION["UID"] = 1;
        header("Location: admin.php");

        
    }
    
    
    $sql2 = "SELECT DID from delivery_personnel WHERE aadhaar = $name and password = '$password'";
    $retval0 = mysqli_query($conn,$sql2);
    if(mysqli_num_rows($retval0)>0){
        $row0 = mysqli_fetch_assoc($retval0);    
        $uid = $row0['DID'];
       
        $_POST['DID'] = $uid;

        $_SESSION["DID"] = $uid;
        
        header("Location: deliveries.php");
    }
    else{
        echo'<script>alert("Incorrect username or password");</script>';
    }
    }
    
?>
<!DOCTYPE html>
    <head>
        
        <title>Welcome</title>
        <link rel='stylesheet' type = 'text/css' href = 'selector.css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    <div class="row">
        <div class="col-md-6">
            
            <div id = 'logo'><img src="images/LlogoT.png" width="400px"></div>
        
    
            <div id = "login-card">
                <a  href="signup.php"><button class='btn btn-lg'>Sign Up</button></a>
                <a  href="login.php"><button class='btn btn-lg'>User Log In</button></a>
                <a  href="login_delivery.php"><button class='btn btn-lg'>Delivery Personnel Log In</button></a>
                <a  href="admin_login.php"><button class='btn btn-lg'>Admin Log In</button></a>
                <a  href="mailto:adithyagy.ai21@bmsce.ac.in"><button class='btn btn-lg'>Want to join us? Contact Us</button></a>
            </div>
               
        </div>
        <div class="col-md-6" id="something" >
        <div class="center">
            <h1>Login</h1>
            <form method="post" action="login_delivery.php">
                <div class="type1">
                    <input type="email" required name = "name" value = "<?php if(isset($_POST['name'])) echo htmlspecialchars($_POST['name'])?>">
                    <span></span>
                    <label>Aadhaar Number</label>
                </div>
                <div class="type1">
                    <input type="password" required name = "password" value = "<?php if(isset($_POST['password'])) echo htmlspecialchars($_POST['password'])?>">
                    <span></span>
                    <label>Password</label>
                </div>
                
                <input type="submit" value="Login">
                
            </form>
        </div>
        </div>
    </div>
    <div class="ripple-background">
        <div class="circle shade1 xxlarge" ></div>
        <div class="circle shade2 xlarge" ></div>
        <div class="circle shade3 large" ></div>
        <div class="circle shade4 medium" ></div>
        <div class="circle shade5 small" ></div>
    </div>
        
        
</body>        
</html>
