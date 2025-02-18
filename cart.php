<?php
    $num1 = $_POST["num1"];
    $num2 = $_POST["num2"];
    $num3 = $_POST["num3"];
    $type = $_POST["type"];

    $total = ($num1*450)+($num2*580)+($num3*650);
    $shipping = checkshipping($type);

    $totalPrice = $total + $shipping;

    $discount = dis($totalPrice) ;


    $netprice = $totalPrice -$discount; 
    
?>
<div class="result">
    <p >Shipment Type :<i><?php echo $type ?> (<?php echo $shipping ?> THB)</i></p>
    <p >Discount : <i> <?php echo $discount ?> </i></p>
    <p >Net Price :<i><?php echo $netprice ?></i></p><br>
    <p >Thank You Very Much</p>
</div>
<?php
    function checkshipping($type){
        if($type== "flash")
            return $type = 40;
        elseif($type == "EMS")
            return $type = 50;
        else
            return $type = 60;
    }
    function dis($totalPrice){
        if($totalPrice > 5000)
            return $discount = 0.15*$totalPrice ;
        elseif($totalPrice > 3000)
            return $discount = 0.10*$totalPrice ;
    }

?>