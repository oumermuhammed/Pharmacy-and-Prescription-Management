
<?php
$msg = "";
include 'header.php';
?>
<style>
#viewtable {
    ;

}
#viewtable,th,td {
    border: 1px solid #0160A4;
}
#viewtable th{
    color: #CC0000; font-size: large;
    background-color: #cccccc;
    border: 1px solid #ffffff;
}
#viewtable td{
    background-color: #b7cebd;
}
</style>
<div class="wrap" style="height:100%" >
    <div class="content">
        <div class="grids">
            <span style="color: red"><?php
                echo $msg;
                ?>
            </span>
            <div style="font-size: x-large;color: #880000">Select Viewing Criteria</div>
            <form name="newdrug" action="viewDrug.php" method="POST" >    
                <table border="1" width="100%" cellspacing="1">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table  width="50" cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td>Drug Name</td>
                                            <td>
                                                <select name="Product_Name">
                                                    <option value="">Product Name</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select Product_Name from drug")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Product_Name'] . "' label='" . $query['Product_Name'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Drug Type</td>
                                            <td>
                                                <select name="Type">
                                                    <option value="">Type</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select Type from drug")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Type'] . "' label='" . $query['Type'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dosage Form</td>
                                            <td>
                                                <select name="Dosage_Form">
                                                     <option value="">Dosage Form</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select Dosage_Form from drug")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Dosage_Form'] . "' label='" . $query['Dosage_Form'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Manufacturer</td>
                                            <td>
                                                <select name="Manufacturer">
                                                     <option value="">Manufacture</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select Manufacturer from drug")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Manufacturer'] . "' label='" . $query['Manufacturer'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td>Root Of Admin</td>
                                            <td>
                                                <select name="Root_Of_Admin">
                                                     <option value="">Root of Admin</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select Root_Of_Admin from drug")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Root_Of_Admin'] . "' label='" . $query['Root_Of_Admin'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            </tr>
                                            <tr>
                                               <td>Quantity</td>
                                            <td>
                                                <select name="quantity">
                                                     <option value="">Quantity 0 or more</option>
                                                     <option value="0">Quantity 0</option>
                                                     <option value="0ormore">Quantity >0</option>
                                                </select>
                                            </td>
                                            </tr>
                                            <td>
                                                <input type="submit" value="View Drug" name="submit" />    
                                            </td>
                                            
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </form>    


            </div>
         </div>
</div>
<?php

if (isset($_POST['submit'])) {
   
     $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    $Product_Name = $_POST['Product_Name'];
    $Type = $_POST['Type'];
    $Dosage_Form = $_POST['Dosage_Form'];
    $Manufacturer = $_POST['Manufacturer'];
    $Root_Of_Admin = $_POST['Root_Of_Admin'];
    $quantity = $_POST['quantity'];
    $criteria="";
    if($Product_Name!=""){
        $criteria=$criteria==""?"Product_Name='".$Product_Name."'":$criteria." and Product_Name='".$Product_Name."'";
    }
    if($Type!=""){
        $criteria=$criteria==""?"Type='".$Type."'":$criteria." and Type='".$Product_Name."'";
    }
    if($Dosage_Form!=""){
        $criteria=$criteria==""?"Dosage_Form='".$Dosage_Form."'":$criteria." and Dosage_Form='".$Dosage_Form."'";
    }
    if($Manufacturer!=""){
        $criteria=$criteria==""?"Manufacturer='".$Manufacturer."'":$criteria." and Manufacturer='".$Manufacturer."'";
    }
    if($Root_Of_Admin!=""){
        $criteria=$criteria==""?"Root_Of_Admin='".$Root_Of_Admin."'":$criteria." and Root_Of_Admin='".$Root_Of_Admin."'";
    }
    if($quantity!=""){
        if($quantity=="0")
        $criteria=$criteria==""?"current_balance=0":$criteria." and current_balance=".$quantity."";
        else
           $criteria=$criteria==""?"current_balance>0":$criteria." and current_balance>0"; 
    }
    
    $query="";
    if($criteria=="")
        $query="select* from drug,drug_detail,account where Health_Organization=(SELECT `Health_Organization` FROM `account` WHERE account.Uname='".$_SESSION['uname']."' LIMIT 1) order by Exp_date";
    else     
        $query="select* from drug,drug_detail,account where $criteria and Health_Organization=(SELECT `Health_Organization` FROM `account` WHERE account.Uname='".$_SESSION['uname']."' LIMIT 1) order by Exp_date";
   if ($result=mysqli_query($con, $query)) {
        if (mysqli_num_rows($result) >0) {
echo '<table id="viewtable" >
            <thead>
            <tr>
            
            <th>Batch Number</th>
            <th>Product Name</th>
            <th>Type</th>
            <th>Dosage Form</th>
            <th>Manufacturer</th>
            <th>Cost</th>
            <th>Root Of Admin</th>
            <th>Strength</th>
            <th>Unit Of Issue</th>
            <th>Each Unit of Issue Quantity</th>
            <th>Least Counting Unit</th>
            <th>Least Counting Unit Quantity</th>
            <th>Mfg.Date</th>
            <th>Receiving Date</th>
            <th>Expiry Date</th>
            <th>received</th>
            <th>Lost<br>Damaged</th>
            <th>Issued/Sold Quantity</th>
            <th>Balance</th>
            <th>Last Action</th>
            </tr>
            </thead>
            <tbody>';
   while($row=mysqli_fetch_array($result)){
    echo "<tr><td>".$row['batch_No']."</td>"; 
    echo "<td>".$row['Product_Name']."</td>";
    echo "<td>".$row['Type']."</td>";       
    echo "<td>".$row['Dosage_Form']."</td>";       
    echo "<td>".$row['Manufacturer']."</td>";       
    echo "<td>".$row['Cost']."</td>";       
    echo "<td>".$row['Root_Of_Admin']."</td>";       
    echo "<td>".$row['Strength']."</td>";       
    echo "<td>".$row['Unit_Of_Issue']."</td>";       
    echo "<td>".$row['Quantity']."</td>";       
    echo "<td>".$row['least_Unit']."</td>";       
    echo "<td>".$row['Each_quantity']."</td>";       
    echo "<td>".$row['MFG_Date']."</td>";       
    echo "<td>".$row['receiving_Date']."</td>";       
    echo "<td>".$row['Exp_date']."</td>";       
    echo "<td>".$row['lost_or_Adjestment']."</td>";       
    echo "<td>".$row['received']."</td>";       
    echo "<td>".$row['issued']."</td>";       
    echo "<td>".$row['current_balance']."</td>";       
    echo "<td>".$row['remark']."</td></tr>";       
    }
        echo "</tbody></table>";
    } else
        echo ' <span style="color: red">No Drug To display</span>';
    } else
        echo ' <span style="color: red">No Drug To display</span>';
}
?>

<?php

include_once 'footer.php';
?>
