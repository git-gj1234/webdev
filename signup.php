<?PHP
// form handler
if($_POST && isset($_POST['name'],$_POST['password'],$_POST['email'],$_POST['phone'],$_POST['confirm_password'],$_POST['ad1'],$_POST['ad2'],$_POST['ad3'])) {   
    
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
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $ad1 = $_POST['ad1'];
    $ad2 = $_POST['ad2'];
    $ad3 = $_POST['ad3'];
    $confirm_password = $_POST['confirm_password'];

    $sql2 = "SELECT email from users";
    $retval0 = mysqli_query($conn,$sql2);
    if(mysqli_num_rows($retval0)>0){
        while($row = mysqli_fetch_assoc($retval0)){

            if ($row['email']==$email){
                echo "<script language='javascript'>
                alert('Email already exists. Try logging in');
                window.location.href='http://localhost/time/login.php';
                </script>
                ";
                die;
            }
        }
    }
    if($password != $confirm_password){
        echo "<script language='javascript'>
                alert('Password Mismatch!!');
                </script>
                ";                
    }
    else if(!is_numeric($phone)){
        echo "<script language='javascript'>
                alert('Please enter a valid phone number');
                </script>
                ";         
    }
    else{
        $sql2 = "SELECT MAX(UID) from users";
        $retval0 = mysqli_query($conn,$sql2);
        if(mysqli_num_rows($retval0)>0){
            $row0 = mysqli_fetch_assoc($retval0);
            $v0 = $row0['MAX(UID)'];
            $v1 = $v0+1;
    
    
            $sql = "INSERT into users values($v1,'$name','$ad1','$ad2','$ad3','$phone','$email','$password')";
            $retval = mysqli_query($conn,$sql);
            
            header("Location: https://localhost/time/login.php");
        }
        
        echo'<script>function validate(){alert("procceding to login page");return true;}</script>';

    }
    
   
}
?>

<html>
    <head>
        <link rel="stylesheet" href="signup.css">
    </head>
    <body>
    
        <div class="center" >
            <h1>Sign Up</h1>
            
        
            <form method="post" onsubmit = "return validate()">
                
                <table width="100%" >
                <tr><td>
                <div class="type1">
                    <input type="text"  required name = "name" value = "<?php if(isset($_POST['name'])) echo htmlspecialchars($_POST['name'])?>">
                    <span></span>
                    <label>Choose a Username</label>
                </div>
                <div class="type1">
                    <input type="password" required name = "password" value = "<?php if(isset($_POST['password'])) echo htmlspecialchars($_POST['password'])?>" >
                    <span></span>
                    <label>Create Password</label>
                </div>
                <div class="type1">
                    <input type="password"  required name = "confirm_password" value = "<?php if(isset($_POST['confirm_password'])) echo htmlspecialchars($_POST['confirm_password'])?>">
                    <span></span>
                    <label>Confirm Password</label>
                </div>
                <div class="type1">
                    <input type="text" required name = "phone" value = "<?php if(isset($_POST['phone'])) echo htmlspecialchars($_POST['phone'])?>">
                    <span></span>
                    <label>Phone Number</label>
                </div>
                </td>
                <td>

               
                <div class="type1">
                    <input type="text" required name = "ad1" value = "<?php if(isset($_POST['ad1'])) echo htmlspecialchars($_POST['ad1'])?>" >
                    <span></span>
                    <label>Address Line 1</label>
                </div>
                <div class="type1">
                    <input type="text" required name = "ad2" value = "<?php if(isset($_POST['ad2'])) echo htmlspecialchars($_POST['ad2'])?>">
                    <span></span>
                    <label>Address Line 2</label>
                </div>
                <div class="type1">
                    <input type="text"required name = "ad3" value = "<?php if(isset($_POST['ad3'])) echo htmlspecialchars($_POST['ad3'])?>" > 
                    <span></span>
                    <label>Address Line 3</label>
                </div>
                
                <div class="type1">
                    <input type="text" required name = "email" value = "<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email'])?>">
                    <span></span>
                    <label>Email</label>
                </div>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                <div class="textlogin">
                    Already a member? <a href="login.php">Login</a>
                </div>
                    
</td></tr>
                <tr>
                    <td colspan=2>
                
                    <input type="submit" value="Sign Up">
</td>
</tr>
            
                
            </form>

        </table>
        </div>
    
    </body>
</html>