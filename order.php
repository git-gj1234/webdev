<!DOCTYPE html>
<title>valmart</title>

<head class="a1">
    <link rel="stylesheet" type="text/css" href="home1.css">
    <link rel="stylesheet" type="text/css" href="order.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src='home1.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "STORE";
    global $conn;
    $conn = mysqli_connect($host,$user,$pass,$database);

    session_start(); // start the session

// set $uid to 1 if the user is not logged in
if (!isset($_SESSION['UID'])) {
    $uid = 1;
} else {
    // set $uid to the same value if the user is logged in
    $uid = $_SESSION['UID'];
}

?>

<body>
    <div class="shift"></div>
    <nav id="TopRibbon">
        <a href="home1.php"><img id='logo' src="images/Llogo.jpg" alt=""></a>

        <div id="profile">
            <img src="images/user2.png" alt="user icon">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                <?php
                        
                        if(isset($_SESSION['UID'])){
                            $sql_fetch = "select * from users where uid = $uid";
                            $retval_fetch = mysqli_query($conn, $sql_fetch);
                            if (mysqli_num_rows($retval_fetch) > 0) {
                                $row_fetch = mysqli_fetch_assoc($retval_fetch);
                                echo $row_fetch['User_name'];
                            }
                        }
                    ?>
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a class='dropdown-item' href="profile_page.php">Account</a></li>
                    <li><a class='dropdown-item' href="order.php">Order History</a></li>
                    <li><a class='dropdown-item' href="cart.php">Cart</a></li>
                    <div class="dropdown-divider"></div>
                    <li><a class='dropdown-item' href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

<?php
$r=0;
$host = "localhost";
$user = "root";
$pass = "";
$database = "STORE";
$conn = mysqli_connect($host,$user,$pass,$database);
if(!$conn){
    die('Could not connect: '.mysqli_connect_error());
}
?>


    <div class='wrapper'>
        <h1 id='Heading'>
            Your Orders
        </h1>

        <ul class="list-group">
            <li class="list-group-item">
                <div class="order headings">
                    <div>Order ID</div>
                    <div>Ordering Date</div>
                    <div>Date of Delivery</div>
                    <div>Status</div>
                    <div>Total</div>
                    <div>Delivery<br> personnel</div>
                    <div>Delivery<br> Contact</div>
                </div>
            </li>
        <?php
        $sql0 = "SELECT * from orders WHERE UID = $uid order by OID desc;";
        $retval0 = mysqli_query($conn,$sql0);
        if(mysqli_num_rows($retval0)>0){
            while($row = mysqli_fetch_assoc($retval0)){

                $oid = $row['OID'];
                $doo = $row['Date_of_order'];
                $dod = $row['Date_of_delivery'];
                if ($dod == NULL){
                    $dod  = "Your order will be delivered within 5 business days of order date";
                }
                $price = $row['total'];
                $stat = $row['stat'];
                $DID = $row['DID'];
                if($DID == NULL){
                    $name =  "your order has been placed. It will be confirmed by one of our delivery personnel shortly";
                    $phone = "You will be able to view a phone number after a driver has confirmed your order";
                }
                else{
                    $get_driver_detials = "SELECT * from Delivery_personnel WHERE DID = $DID";
                    $retval1 = mysqli_query($conn,$get_driver_detials);
                    if(mysqli_num_rows($retval1)>0){
                        while($row2 = mysqli_fetch_assoc($retval1)){                            
                            $name = $row2['Delivery_name'];
                            $phone = $row2['phone_number'];                            
                        }
                    }
                }

                echo '
                <li class="list-group-item">
                        <details>
                            <summary>
                                <div class="order">
                                    <div>',$oid,'</div>
                                    <div>',$doo,'</div>
                                    <div>',$dod,'</div>
                                    <div>',$stat,'</div>
                                    <div><span>&#8377;</span>',$price,'</div>                                    
                                    <div id = \'orderID\'>',$name,'</div>
                                    <div>',$phone,'</div>
                                </div>
                            </summary>
                            <table class = "table-responsive table-sm table-hover">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                </tr>
                            ';
                            $sql3 = "SELECT * from bills WHERE OID = $oid;";
                            $retval3 = mysqli_query($conn,$sql3);
                            if(mysqli_num_rows($retval3)>0){
                                while($row3 = mysqli_fetch_assoc($retval3)){

                                    $PIDd = $row3['PID'];
                                    $sub_query = "SELECT name,price,link from store_inv where store_inv.PID = '$PIDd';";
                                    $retval4 = mysqli_query($conn,$sub_query);
                                    $row4 = mysqli_fetch_assoc($retval4);
                                    $pic = $row4['link'];

                                    echo '
                                    <tr>
                                            <td><br>';
                                            echo "<img src=\"$pic\" class ='item-pic'>";
                                            echo $row4['name'],'</td>
                                            <td><br><span>&#8377;</span>',$row4['price'],'</td>
                                            <td><br>',$row3['quan'],'</td>
                                            <td><br><span>&#8377;</span>',$row3['price'],'</td>
                                    </tr>';
                                }
                            }
                            echo'
                                <tr >
                                    <td colspan = "3">Total</td>
                                    <td><span>&#8377;</span>',$price,'</td>
                                </tr>
                            </table>
                        </details>
                    </li>
                ';}
            echo'</ul>';}
        ?>
    </div>


 