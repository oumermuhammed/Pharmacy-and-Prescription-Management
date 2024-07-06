
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
            <form name="viewsolddrug" action="viewsolddrug.php" method="POST" >    
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
                                            <td>Sold Date</td>
                                            <td>
                                            <input type="date" name="date" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sold By</td>
                                            <td>
                                                <select name="seller">
                                                     <option value="">All Sellers</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select FullName from sold_drug,account where sold_drug.uName=account.Uname")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                          echo "<option value='" . $query['FullName'] . "' label='" . $query['FullName'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td>Sold</td>
                                            <td>
                                                <select name="prescription">
                                                <option value="">All</option>
                                                <option value="1">With Prescription</option>
                                                <option value="0">With No Prescription</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
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
    $date=$_POST['date'];
    $seller=$_POST['seller'];
    $prescription=$_POST['prescription'];
    $totalCost="";
    $criteria="";
    if($date!=""){
        $criteria="date='".$date."'";
    }
    if($seller!=""){
       $criteria= $criteria==""?"account.FullName='".$seller."' and sold_drug.uName=account.Uname":$criteria." and account.FullName='".$seller."' and sold_drug.uName=account.Uname";
    }
     if($prescription!=""){
         if($prescription=="1")
        $criteria=$criteria==""?"prescription_no IS NOT NULL":$criteria." and prescription_no IS NOT NULL";
    else
       $criteria=$criteria==""?"prescription_no IS NULL":$criteria." and prescription_no IS NULL";  
     }
     
   $query="";
  if($criteria==""){
        $query="select* from sold_drug,account where sold_drug.uName=account.Uname order by date";
         $totalCost="select SUM(cost) as Totalsold, SUM(tax) as Totaltax from sold_drug,account where sold_drug.uName=account.Uname order by date";
    }
   else{
       $query="select* from sold_drug,account where $criteria and sold_drug.uName=account.Uname order by date";
       $totalCost="select SUM(cost) as Totalsold, SUM(tax) as Totaltax from sold_drug,account where $criteria and sold_drug.uName=account.Uname order by date";
    }
     if ($result=mysqli_query($con, $query)) {
        if (mysqli_num_rows($result) >0) {
echo '<table id="viewtable" >
            <thead>
            <tr>
            <th>Quantity</th>
            <th>Tax</th>
            <th>Cost</th>
            <th>Sold Date</th>
            <th>Full Name</th>
            
            </tr>
            </thead>
            <tbody>';
$result=mysqli_query($con, $query);
while($row=mysqli_fetch_array($result)){
    echo "<tr><td>".$row['quantity']."</td>"; 
    echo "<td>".$row['tax']."</td>";
    echo "<td>".$row['cost']."</td>";       
    echo "<td>".$row['date']."</td>";       
    echo "<td>".$row['FullName']."</td></tr>";       
   }
   $result=mysqli_query($con, $totalCost);
   $row=mysqli_fetch_array($result);
   echo "<tr style='font-size:x-large; color: #dd3333'><td>Total Cost: </td><td>".$row['Totalsold']."</td></tr>";       
   echo "<tr style='font-size:x-large;color: #dd3333'><td>Total Tax: </td><td>".$row['Totaltax']."</td></tr>";
   echo "<tr style='font-size:x-large;color: #dd3333'><td>Net (Total Cost - Total Tax): </td><td>".($row['Totalsold']-($row['Totalsold']*$row['Totaltax']))."</td></tr>";
    
    echo "</tbody></table>";
    } else
        echo ' <span style="color: red">No Sold Drug</span>';
    } else
        echo ' <span style="color: red">No Sold Drug</span>';
}
?>

<?php

include_once 'footer.php';
?>
