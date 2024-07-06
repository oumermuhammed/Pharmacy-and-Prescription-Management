
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
            <form name="newdrug" action="viewPrescription.php" method="POST" >    
                <table border="1" width="100%" cellspacing="1">
                    <thead>
                        <tr>
                            <th> </th>
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
                                            <td>Card Number</td>
                                            <td>
                                                <select name="card_No">
                                                    <option value="">Card Number</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select distinct card_No from prescription")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['card_No'] . "' label='" . $query['card_No'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Prescription Date</td>
                                            <td>
                                                <input type="date" name="date" value=""/> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Diagnosis</td>
                                            <td>
                                                <select name="Diagnosis">
                                                     <option value="">Diagnosis</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select Diagnosis from prescription")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Diagnosis'] . "' label='" . $query['Diagnosis'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Prescribed By</td>
                                            <td>
                                                <select name="prescriber">
                                                     <option value="">Doctor</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select FullName from prescription,account where prescription.UName=account.Uname")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['FullName'] . "' label='" . $query['FullName'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td>Prescription Status</td>
                                            <td>
                                                <select name="status">
                                                     <option value="">Status</option>
                                                     <option value="1">Drug Taken</option>
                                                     <option value="0">No Drug Taken</option>
                                                    
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="submit" value="View Prescription" name="submit" />    
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
    $card_No = $_POST['card_No'];
    $date = $_POST['date'];
    $Diagnosis = $_POST['Diagnosis'];
    $prescriber = $_POST['prescriber'];
    $status=$_POST['status'];
    $criteria="";
    
    if($card_No!=""){
        $criteria="card_No='".$card_No."'";
    }
    if($date!=""){
        $criteria=($criteria=="")?("prescription.date='".$date."'"):($criteria." and prescription.date='".$date."'");
        }
    if($Diagnosis!=""){
        $criteria=$criteria==""?"Diagnosis='".$Diagnosis."'":$criteria." and Diagnosis='".$Diagnosis."'";
    }
    if($prescriber!=""){
       $criteria= $criteria==""?"account.FullName='".$prescriber."' and prescription.UName=account.Uname":$criteria." and account.FullName='".$prescriber."' and prescription.UName=account.Uname";
    }
     if($status!=""){
        $criteria=$criteria==""?"prescription.status=$status":$criteria." and prescription.status=$status";
    }
     
   $query="";
  if($criteria==""){
        $query="select* from prescription,account where prescription.UName=account.Uname order by date";
    }
   else{
       $query="select* from prescription,account where $criteria order by date";
    }
   if ($result=mysqli_query($con, $query)) {
        if (mysqli_num_rows($result) >0) {
echo '<table id="viewtable" >
            <thead>
            <tr>
            <th>Diagnosis</th>
            <th>Duration</th>
            <th>Frequency</th>
            <th>Dosage Form</th>
            <th>root of admin</th>
            <th>Strength</th>
            <th>Presc. Date</th>
            <th>card_No</th>
            <th>status</th>
            <th>Drug_Name</th>
            <th>By Doctor</th>
            <th>Prescriber Organization</th>
            </tr>
            </thead>
            <tbody>';
while($row=mysqli_fetch_array($result)){
    echo "<tr><td>".$row['Diagnosis']."</td>"; 
    echo "<td>".$row['Duration']."</td>";
    echo "<td>".$row['frequency']."</td>";       
    echo "<td>".$row['Dosage_form']."</td>";       
    echo "<td>".$row['root_of_admin']."</td>";       
    echo "<td>".$row['strength']."</td>";       
    echo "<td>".$row['date']."</td>";       
    echo "<td>".$row['card_No']."</td>";       
    if(($row['status']==1))
        $status="Drug Taken";
    else
       $status="No drug taken";
    echo "<td>".$status."</td>";   
    echo "<td>".$row['Drug_Name']."</td>";       
    echo "<td>".$row['FullName']."</td>";       
    echo "<td>".$row['Health_Organization']."</td></tr>";       
   }
    echo "</tbody></table>";
    } else
        echo ' <span style="color: red">No Prescription</span>';
    } else
        echo ' <span style="color: red">No Prescription</span>';
}
?>

<?php

include_once 'footer.php';
?>
