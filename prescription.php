<!DOCTYPE html>
<?php
$msg = "";
include 'header.php';
if (isset($_POST['submit'])) {
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");

    $query = "INSERT INTO prescription( Diagnosis, Duration, frequency,Dosage_form, root_of_admin, strength, date, card_No, UName,Drug_Name,status) VALUES "
            . "('" . $_POST['diagnosis'] . "','" . $_POST['duration'] . "','" . $_POST['frequency'] . "','" . $_POST['dosage'] . "','" . $_POST['rofadmin'] . "','" . $_POST['strength'] . "',NOW(),'" . $_POST['cardno'] . "','" . $_SESSION['uname'] . "','" . $_POST['Drug_Name'] . "',0)";
    if (mysqli_query($con, $query))
        $msg = "Prescription Recorded Successfully";
    else {
        $msg = "can't Create Prescription" . mysqli_error($con);
    }
}
?>


<div class="wrap" style="height:100%" >
    <div class="content">
        <div class="grids">
            <span style="color:red">
                <?php
                echo $msg;
                ?></span>
            <form name="prescription" action="prescription.php" method="POST" >    
                <table  width="50" cellspacing="1">
                    <thead style="font-size: larger">
                        <tr>
                            <th></th>
                            <th><h1 style="color: darkgoldenrod; font-style: normal">Prescription Detail</h1></th>

                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Diagnosis</td>
                            <td><textarea name="diagnosis"  cols="40" required="required" >
                                </textarea></td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td>
                                <input type="text"  name="duration" value="" placeholder="Duration" required="required"/>
                            </td>
                        </tr>
                        <tr><td>Frequency</td>
                            <td><input type="text" name="frequency" value="" placeholder="frequency and period" required="required"/></td></tr>
                        <tr>
                            <td>Dosage Form</td>
                            <td>
                                <input type="text" name="dosage" value="" placeholder="Dosage Form" required="required"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Drug Name</td>
                            <td>
                                <input type="text" name="Drug_Name" value="" placeholder="Drug name" required="required"/>
                            </td>
                        </tr>
                        <tr><td>Root Of Admin</td>
                            <td><input type="text" name="rofadmin"  value="" placeholder="Root of admin" required="required"/></td>
                        </tr>

                        </tr>
                        <tr>
                            <td>strength</td>
                            <td><input type="text" name="strength"  value="" placeholder="Strength" />
                            </td>
                        </tr>
                        <tr>
                            <td>Card Number & Patient Full Name</td>
                            <td>
                                <select name="cardno" contenteditable="true" title="select card No">
                                    <?php
                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                    if ($result = mysqli_query($con, "select FullName,Card_No from patient")) {
                                        while ($query = mysqli_fetch_array($result)) {
                                            echo "<option value='" . $query['Card_No'] . "' label='" . $query['Card_No'] . "   " . $query['FullName'] . "' ></option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td> 
                            </td>
                        </tr>
                        <tr><td></td>
                            <td>
                                <input type="submit" name="submit" value="Record Prescription" />
                            </td>
                    </tbody>
                </table>
            </form>
            <div class="clear"> </div>
        </div>
        <div class="clear"> </div>

    </div>
</div>

<?php
include_once 'footer.php';
?>