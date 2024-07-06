
<?php
$msg = "";
include 'header.php';
?>



<div class="wrap" style="height:100%" >
    <div class="content">
        <div class="grids">
            <span style="color: red"><?php
                echo $msg;
                ?>
            </span>
            <h3 style="color: #9f2b1e;font-size: larger">Update Unsold Prescription yet!</h3>
            <form name="updatePrescription" action="updateprescription.php" method="POST" >    

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
                                            <td>Patient Card No.: Presc. Date : Diagnosis</td> 
                                            <td>
                                                <select name="prescriptionno" onchange="document.updatePrescription.submit();" required="required" >
                                                    <option>--</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "SELECT * FROM prescription where UName='" . $_SESSION['uname'] . "'  and status=0")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Prescription_No'] . "' label='" . $query['date'] . " : " . $query['card_No'] . " : " . $query['Diagnosis'] . "' ></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
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
                                            <td>Patient Full Name</td>
                                            <td>
                                                <input type="text" disabled="disabled" name="patientname">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="submit" name="update" value="Update Drug" />
                                            </td>
                                            <td id="msg"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>

                            </td>
                        </tr>
                    </tbody>
                </table>

            </form>    


            <div class="clear"> </div>
        </div>
        <div class="clear" > </div>

    </div>
</div>
<?php
if (isset($_POST['prescriptionno']) && $_POST['prescriptionno'] != "--" && !(isset($_POST['update']))) {
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    if ($result = mysqli_query($con, "select distinct * from prescription where Prescription_No=" . $_POST['prescriptionno'] . "")) {
        $query = mysqli_fetch_array($result);
        $Diagnosis = $query['Diagnosis'];
        $Duration = $query['Duration'];
        $frequency = $query['frequency'];
        $Dosage_form = $query['Dosage_form'];
        $root_of_admin = $query['root_of_admin'];
        $strength = $query['strength'];
        $date = $query['date'];
        $card_No = $query['card_No'];
        $Drug_Name = $query['Drug_Name'];
        $presno=$_POST['prescriptionno'];
                                                              
        //get Patient Name
        $result = mysqli_query($con, "select FullName from prescription,patient where Prescription_No=".
        $_POST['prescriptionno'] ." and patient.Card_No=prescription.card_No");
        $query = mysqli_fetch_array($result);
        $patientName = $query['FullName'];
        $show = <<<ASSIGN
        <script type="text/javascript">
            document.updatePrescription.strength.value='$strength';
            document.updatePrescription.rofadmin.value='$root_of_admin';
            document.updatePrescription.Drug_Name.value='$Drug_Name';
            document.updatePrescription.dosage.value='$Dosage_form';
            document.updatePrescription.frequency.value='$frequency';
            document.updatePrescription.duration.value='$Duration';
            document.updatePrescription.diagnosis.value='$Diagnosis';
            document.updatePrescription.patientname.value='$patientName';    
            document.updatePrescription.patientname.value='$patientName';           
            document.updatePrescription.prescriptionno.value='$presno';           

        </script>   
ASSIGN;
        echo $show;
    }
} else if (isset($_POST['prescriptionno']) && $_POST['prescriptionno'] != "--" && (isset($_POST['update']))) {
    
    $query = mysqli_fetch_array($result);
        $Diagnosis = $_POST['diagnosis'];
        $Duration = $_POST['duration'];
        $frequency = $_POST['frequency'];
        $Dosage_form = $_POST['dosage'];
        $root_of_admin = $_POST['rofadmin'];
        $strength = $_POST['strength'];
        $Drug_Name = $_POST['Drug_Name'];
        $presno=$_POST['prescriptionno'];
           //update Prescription
    $query = "update prescription set Diagnosis='" . $Diagnosis."', Duration='" . $Duration ."', frequency='" . $frequency . "',Dosage_form='" . $Dosage_form .
            "',root_of_admin='" . $root_of_admin . "',strength='" . $strength . "',Drug_Name='" . $Drug_Name .
            "' where Prescription_No=" . $presno . "";
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    if ($result = mysqli_query($con, $query)) {
        $show = <<<ASSIGN
        <script type="text/javascript">
                document.getElementById("msg").innerHTML="<span style='color: #22aa11;font-size:larger'> Successfully Updated!</span>";

        </script>   
ASSIGN;
        echo $show;
    } else {
        $show = <<<ASSIGN
        <script type="text/javascript">
                document.getElementById("msg").innerHTML="<span style='color: #aa1111;font-size:larger'> Update Failed!</span>";
        </script>   
ASSIGN;
        echo $show;
        echo mysqli_error($con);
    }
}
?>

<script type="text/javascript">

    <?php
    include_once 'footer.php';
    ?>
