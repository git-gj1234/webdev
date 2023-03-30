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
        echo $uid;
        $_POST['DID'] = $uid;
        session_start();
        $_SESSION = $_POST;
        session_write_close();    
        header("Location: deliveries.php");
    }
    else{
        echo'<script>alert("Incorrect username or password");</script>';
    }
    }
    
?>
<html>
    <head>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <div class="center">
            <h1>Login</h1>
            <form method="post">
                <div class="type1">
                    <input type="number" required name = "name" value = "<?php if(isset($_POST['name'])) echo htmlspecialchars($_POST['name'])?>">
                    <span></span>
                    <label>Aadhaar Number</label>
                </div>
                <div class="type1">
                    <input type="password" required name = "password" value = "<?php if(isset($_POST['password'])) echo htmlspecialchars($_POST['password'])?>">
                    <span></span>
                    <label>Password</label>
                </div>
                <div class="signup" style="text-align: left;">Not delivery personnel? <a href="selector.php">Click here.</a></div>

                <input type="submit" value="Login">
            </form>
            <div class="signup">
                    Want to join us? <a href="mailto:adithyagy.ai21@bmsce.ac.in">Contact us</a>
                </div>
        </div>
    </body>
</html>
