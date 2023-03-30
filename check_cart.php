<?php
global $uid;
$uid = $_POST['uid']; ?>
<div class="table-responsive" id="recentcart">
    
    <table class="table ">
        <thead><tr>
            <th>Item</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Amount</th></tr>
        </thead>
        <tbody>
        <?php
        $host = "localhost";
        $user = "root";
        $pass = "";
        $database = "STORE";
        $conn = mysqli_connect($host, $user, $pass, $database);
        if (!$conn) {
            die('Could not connect: '.mysqli_connect_error());
        }
        
        $sql5 = "SELECT s.pid, s.link,s.price,s.name,c.quan,c.price as amt from store_inv s, cart c where s.pid=c.pid and c.uid=$uid"; 
        $retval5 = mysqli_query($conn, $sql5);
        $total = 0;
        if (mysqli_num_rows($retval5) > 0) {
            while ($row5 = mysqli_fetch_assoc($retval5)) {
                $pid= $row5['pid'];
                $link = $row5['link'];
                $price = $row5['price'];
                $name = $row5['name'];
                $quan = $row5['quan'];
                $amt = $row5['amt'];
                $total += $amt;
                echo "<tr class = 'cart-item'>";
                echo "<td><img src=\"$link\" style=\"width:20px;height:20px;\">$name</td>";
                echo "<td>$price</td>";
                $a="cart";
                $a .=$pid;
              ?><td>
    <div id="<?php echo $a; ?>"class="btn-group btn-group-xs">
    <button id="minus" class="btn btn-primary" onclick="updateCart('subraction1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">-</button>
    <span id="quan" class="btn btn-default  "><?php echo $quan; ?></span>
    <button id="plus" class="btn btn-primary" onclick="updateCart('addition1.php', <?php echo $uid; ?>, '<?php echo $pid; ?>','<?php echo $a; ?>')" data-uid="<?php echo $uid; ?>" data-pid="<?php echo $pid; ?>">+</button>
  </div></td>
<?php
                echo "<td>$amt</td>";
                echo "</tr>";
            }
        }
        mysqli_close($conn);
        ?>
        <tr class = 'cart-item'>
            <td colspan="2">Total:</td>
            <td id = 'cartItems'></td>
            <td><?php echo $total; ?></td>
            
        </tr>
        <tr id = 'checkout' class = 'cart-item'>
            <td colspan = "4"> 
                
                <form action="cart.php" method="post">
                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                    <input class = 'btn ' type="submit" name="submit" value="Proceed to Checkout">
                </form>
            </td>
        </tr>   
    
    
    </tbody>
    </table>
</div>
