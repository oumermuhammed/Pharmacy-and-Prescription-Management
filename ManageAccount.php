
<?php
include 'header.php';
$msgs = "";
if (isset($_POST['Submit'])) {
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    $query = " UPDATE `account` SET `Status` = CASE
    WHEN Status = 1 THEN 0
    WHEN Status = 0 THEN 1
  END
WHERE Uname='" . $_POST['uname'] . "'";
    $query2 = "INSERT INTO `account_status`(`Username`, `Reason`, `Timestamp`, `Status`) VALUES ('" . $_POST['uname'] . "','" . $_POST['reason']
            ."',NOW(),(select Uname from account where Uname='" . $_POST['uname'] . "' LIMIT 1));";
    if (mysqli_query($con, $query2) && mysqli_query($con, $query)) {
        $msgs = "Status Updated!!!";
    } else
        $msgs = "can't Update Status" . mysqli_error($con);    
}
else 
   
?>
<style>
    table {
        border-collapse: collapse;
        width: fit-content;
        vertical-align: middle;
    }

    table, td {
        border: 3px solid #0160A4;
    }
    th{
        border: 5px solid #FF8400;
    }
</style>

<br><br><br>
<span style="color: #0f6d75;font-size: x-large;text-align: center">
    <?php
    echo $msgs;
    ?>
</span>
<table >
    <thead>
        <tr >
            <th>User Name</th>
            <th>Employee Id</th>
            <th>Privilege</th>
            <th>Full Name</th>
            <th>Date Created</th>
            <th>Status</th>
            <th>Status Change Reason</th>
            <th>Status Change Date and Time (Sorted By this)</th>

        </tr>
    </thead>
    <tbody>



<?php
if ($_SESSION['privillage'] == "HC Manager" || $_SESSION['privillage'] == "Pharmacy Manager")
    $query = "SELECT* FROM `account`,account_status where account.Uname=account_status.Username and account.Uname !='" . $_SESSION['uname'] .
            "' and Health_Organization=(select Health_Organization from account where privillage='" . $_SESSION['privillage'] . "' LIMIT 1) order by Timestamp";
$con = mysqli_connect("localhost", "root", "prescription", "prescription");
$result = mysqli_query($con, $query);
while ($r = mysqli_fetch_array($result)) {
    echo "<tr>
            <td>" . $r['Username'] . "</td><td>" . $r['Eid'] . "</td><td>" . $r['privillage'] . "</td><td>" . $r['FullName'] . "</td><td>" . $r['Date_Created'] . "</td><td>" . ($r['Status'] == 1 ? "ACtivated" : "Deactivated") . "</td><td>" . $r['Reason'] . "</td><td>" . $r['Timestamp'] . "</td></tr>";
}
?>

    </tbody>
</table>
To change Account Status:
<form style="border: #0f6d75 solid thick; display: block"  action="ManageAccount.php" method="POST">

    <table border="1">
        <thead>
            <tr>
                <th>User Name With Status</th>
                <th>Status changing Reason</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>

                    <select name="uname" contenteditable="true" title="select User Name">
<?php
$con = mysqli_connect("localhost", "root", "prescription", "prescription");
if ($result = mysqli_query($con, "select Uname,Status from account")) {
    while ($query = mysqli_fetch_array($result)) {
        echo "<option value='" . $query['Uname'] . "'>" . $query['Uname'] . "   " . ($query['Status'] == 1 ? "Activated" : "Deactivated") . " </option>";
    }
}
?>

                    </select> 



                </td>
                <td><input type="text" name="reason" value="" required="required" /></td>
                <td> <input type="submit" name="Submit" value="Change Status" /></td>
            </tr>
        </tbody>
    </table>
   
</form>



