
<?php
$msg = "";
include 'header.php';
$presdate = "";
$prescriptionsell = "";
$presnoform = "";
$prescriptionNo = "";
$informDrugs = "";
/*
 * 
 PHP code about selling drug without prescription begins here
 */
if (isset($_POST['submit']) && ($_POST['submit'] == "Prescription Of the Date") && $_POST['choice'] == "without") {
$informDrugs="";    
}
if (isset($_POST['submit']) && $_POST['submit'] == 'Submit specific Drug') {
    $drug = $_POST['drugname'];
}

if (isset($_POST['submit']) && ($_POST['submit'] == "Sell Drug")) {
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    $drug = $_POST['drug'];
    $cost = $_POST['cost'];
    $result = mysqli_query($con, "select * from drug_detail where drug_detail.ProductName='" . $drug . "' and current_balance>0 and drug_detail.Exp_date > Now() ORDER BY Exp_date ASC");
    $quantity = $_POST['quantity'];
    $count = true;
    $addedtonxt = 0;
    $cur_balance = 0;
    while (($row = mysqli_fetch_array($result)) && $count) {
        $remain = $row['current_balance'] - $quantity;
        if ($remain >= 0) {
            $cur_balance = $remain;
            $issuedquantity = $quantity;
            $count = false;
        } else {
            $cur_balance = 0;
            $issuedquantity = $row['current_balance'];
            $quantity = $quantity - $row['current_balance'];
            $count = true;
        }
        // Update Drug detail of sold Drug with specific Batch No.
        $updateDetail = "update drug_detail set issued=(issued+" . $issuedquantity . ") ,current_balance=$cur_balance, remark='Last Action: Sold withOut Prescription' where batch_No='" . $row['batch_No'] . "'";


        if (!mysqli_query($con, $updateDetail))
            echo "Can't Update Drug Details " . mysqli_error($con);
        else {
            echo "<span style='color:green'>Drug Batch Number:" . $row['batch_No'] . " Sold Quantity: $issuedquantity    Remaining: $cur_balance<br></span>";
        }
        //end update drug detail
    }
    /* Record sold drug */
    $query = "INSERT INTO `sold_drug`(`quantity`, `tax`, `cost`, `date`,`uName`) "
            . "VALUES(" . $_POST['quantity'] . "," . $_POST['tax'] . "," . $_POST['quantity'] * $cost . ",NOW(),'" . $_SESSION['uname'] . "');";

    if (mysqli_multi_query($con, $query))
        $msg = "Sold Drug Informaion Recorded Successfully!!!!";
    else {
        $msg = "can't Record Sold Drug Information" . mysqli_error($con) . "<br>" . $query;
    }
    //end update prescription and record sold drug here
}
/*
 * 
 * 
 PHP code about selling drug without prescription ends here
 * 
 * 
 */
if (isset($_POST['submit']) && ($_POST['submit'] == "Prescription Of the Date" && $_POST['choice'] == "with")) {
    $presdate = $_POST['pdate'];
}
if (isset($_POST['submit']) && $_POST['submit'] == 'Submit specific Prescription') {
    $prescriptionNo = $_POST['prescriptionno'];
    // prescription sell
}

if (isset($_POST['submit']) && ($_POST['submit'] == "Sell Prescription")) {
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    $prescriptionNo = $_POST['PrescriptionNo'];
    $result = mysqli_query($con, "select * from prescription,Drug,drug_detail where drug_detail.ProductName=prescription.Drug_Name and drug.Product_Name=drug_detail.ProductName and prescription.Dosage_form=drug.Dosage_form and prescription.root_of_admin=drug.Root_Of_Admin and prescription.strength=drug.strength"
            . " and prescription.Prescription_No=" . $prescriptionNo . " and prescription.status=0 and current_balance>0 and drug_detail.Exp_date > Now() ORDER BY Exp_date ASC");
    $quantity = $_POST['quantity'];
    $count = true;
    $addedtonxt = 0;
    $cur_balance = 0;
    while (($row = mysqli_fetch_array($result)) && $count) {
        $remain = $row['current_balance'] - $quantity;
        if ($remain >= 0) {
            $cur_balance = $remain;
            $issuedquantity = $quantity;
            $count = false;
        } else {
            $cur_balance = 0;
            $issuedquantity = $row['current_balance'];
            $quantity = $quantity - $row['current_balance'];
            $count = true;
        }
        // Update Drug detail of sold Drug with specific Batch No.
        $updateDetail = "update drug_detail set issued=(issued+" . $issuedquantity . ") ,current_balance=$cur_balance, remark='Last Action: Sold with Prescription' where batch_No='" . $row['batch_No'] . "'";

        if (!mysqli_query($con, $updateDetail))
            echo "Can't Update Drug Details " . mysqli_error($con);
        else {
            echo "<span style='color:green'>Drug Batch Number:" . $row['batch_No'] . " Sold Quantity: $issuedquantity    Remaining: $cur_balance<br></span>";
        }
        //end update drug detail
    }


 /* update prescription and record sold drug */
    $query = "INSERT INTO `sold_drug`(`quantity`, `tax`, `cost`, `date`, `Prescription_No`, `uName`) "
            . "VALUES(" . $_POST['quantity'] . "," . $_POST['tax'] . "," . $_POST['quantity'] * $_POST['cost'] . ",NOW()," . $_POST['PrescriptionNo'] . ",'" . $_SESSION['uname'] . "');";
    $query.= " UPDATE prescription SET status=1 where Prescription_No=" . $_POST['PrescriptionNo'];
    if (mysqli_multi_query($con, $query))
        $msg = "Sold Drug Informaion Recorded Successfully!!!!";
    else {
        $msg = "can't Record Sold Drug Information" . mysqli_error($con) . "<br>" . $query;
    }
    /*
     * 
     End update prescription and record sold drug here
     * 
     * 
     */
}
?>


<script type="text/javascript">
    function activate(selection, other) {


        if (selection.value === "with")
            other.removeAttribute('disabled');
        else
            other.disabled = "true";
    }
</script>
<div class="wrap" style="height:100%" >
    <div class="content">
        <div class="grids">


            <span style="color:red;font-size: larger">
                <?php
                echo $msg;
                echo $informDrugs;
                ?>
            </span>
            <table border="1" width="100%" cellspacing="1">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="sellDrug">
                            <form name="sellDrug"  action="selldrug.php" method="POST" >
                                <table   cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th><b></b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sell Drug with</td>
                                            <td>
                                                <select name="choice" onchange="activate(this, document.sellDrug.pdate)">
                                                    <option value="with" label="with Prescription"></option>    
                                                    <option value="without" label="WithoutPrescription"></option>           
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td>Choose Prescription Date</td>
                                            <td><input type="date" name="pdate"  value=""  /></td></tr>

                                    </tbody>
                                </table>
                                <input type="submit" name="submit" value="Prescription Of the Date" />
                            </form>
                        </td>

                        <td id="sellDrugwithprescription">
                            <!--with prescription -->
                            <form name="sellDrugwithprescription" action="selldrug.php" method="POST" >
                                <table   cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th>Select Specific Prescription Of A patient</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Card Number, Name, Diagnosis</td>
                                            <td>
                                                <select name="prescriptionno" contenteditable="true" title="Card Number, Name, Diagnosis">
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");

                                                    if ($result = mysqli_query($con, "select patient.FullName,patient.Card_No,prescription.Prescription_No, prescription.Diagnosis from patient,prescription where prescription.card_No=patient.Card_No and prescription.date='" . $presdate . "' and prescription.status=0")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Prescription_No'] . "' label='" . $query['Card_No'] . "   " . $query['FullName'] . "   " . $query['Diagnosis'] . "' ></option>";
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                                <input type="submit" name="submit" value="Submit specific Prescription" />
                            </form>
                        </td>
                        <td id="sell"> 

                            <!--   sell with prescription lastly-->
                            <form name="sell" action="selldrug.php" method="POST" >
                                <table   cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th><b></b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Detail</td>
                                            <td>

                                                <?php
                                                $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                //$presdate=$_SESSION['presdate'];//presdate
                                                if ($result = mysqli_query($con, "select * from prescription,patient,account where prescription.card_No=patient.Card_No and prescription.Prescription_No=" .
                                                        $prescriptionNo . " and prescription.status=0 and prescription.UName=account.uname")) {
                                                    $query = mysqli_fetch_array($result);


                                                    echo("<textarea name='detail' rows='4' cols='50' disabled='true'>");

                                                    echo ("Patient Name:  " . $query[14] . "&#13;Patient Card No.:  " . $query[12] . "&#13; Date: " . $query[7] .
                                                    "&#13;Diagnosis:  " . $query[1] . "&#13;Duration:  " . $query[2] . "&#13;Frequency:  " . $query[3] .
                                                    "&#13;Dosage Form:  " . $query[4] . "&#13;Root Of Admin:  " . $query[5] . "&#13;Strength:  " . $query[6] .
                                                    "&#13;By Doctor: " . $query[22] . "&#13;By Organization: " . $query[25]);
                                                    echo "</textarea>";
                                                }
                                                ?>

                                            </td>
                                        </tr>
                                        <?php
                                        $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                        //$presdate=$_SESSION['presdate'];//presdate
                                        $q = "select * from prescription,Drug,drug_detail where drug.Product_Name=drug_detail.ProductName and prescription.Dosage_form=drug.Dosage_form and prescription.root_of_admin=drug.Root_Of_Admin and prescription.strength=drug.strength"
                                                . " and prescription.strength=drug.Strength and prescription.Prescription_No=" . $prescriptionNo . " and prescription.status=0";

                                        if ($result = mysqli_query($con, "select * from prescription,Drug,drug_detail where drug_detail.ProductName=prescription.Drug_Name and drug.Product_Name=drug_detail.ProductName and prescription.Dosage_form=drug.Dosage_form and prescription.root_of_admin=drug.Root_Of_Admin and prescription.strength=drug.strength"
                                                . " and prescription.Prescription_No=" . $prescriptionNo . " and prescription.status=0 and current_balance>0 and drug_detail.Exp_date > Now() ORDER BY Exp_date ASC")) {

                                            if (mysqli_num_rows($result) > 0) {
                                                $r = mysqli_query($con, "select SUM(current_balance) as quantity from prescription,Drug,drug_detail where drug_detail.ProductName=prescription.Drug_Name and drug.Product_Name=drug_detail.ProductName and prescription.Dosage_form=drug.Dosage_form and prescription.root_of_admin=drug.Root_Of_Admin and prescription.strength=drug.strength"
                                                        . " and prescription.Prescription_No=" . $prescriptionNo . " and prescription.status=0 and current_balance>0 and drug_detail.Exp_date > Now() ORDER BY Exp_date ASC");
                                                echo "select SUM(current_balance) as quantity from prescription,Drug,drug_detail where drug_detail.ProductName=prescription.Drug_Name and drug.Product_Name=drug_detail.ProductName and prescription.Dosage_form=drug.Dosage_form and prescription.root_of_admin=drug.Root_Of_Admin and prescription.strength=drug.strength"
                                                . " and prescription.Prescription_No=" . $prescriptionNo . " and prescription.status=0 and current_balance>0 and drug_detail.Exp_date > Now() ORDER BY Exp_date ASC";
                                                $max = mysqli_fetch_array($r);
                                                $maxquantity = $max['quantity'];
                                                echo"<td>Quantity</td><td> <select name = 'quantity' required='required'> Label='select Quantity'";
                                                for ($i = 1; $i <= $maxquantity; $i++) {
                                                    echo "<option value='$i'> $i</option>";
                                                }

                                                echo "</select>";
                                                echo("<tr><td>Tax</td><td>");
                                                $query = mysqli_fetch_array($result);
                                                echo "<input type='number' max='1' min='0' name='tax' step='any' value='0' title='Enter tax Ratio'/></td></tr>";
                                                echo "<input type='hidden' name='cost' value='" . $query[16] . "' />";
                                                echo "<input type='hidden' name='PrescriptionNo' value='" . $prescriptionNo . "' />";
                                                //echo "<input type='hidden' name='batchNo' value='" . $query[24] . "' />";
                                                //echo "<input type='hidden' name='ProductName' value='" . $query[25] . "' />";
                                                ///echo "<input type='hidden' name='Exp_date' value='" . $query[27] . "' />";
                                                //echo "<input type='hidden' name='MFG_Date' value='" . $query[28] . "' />";
                                                //echo "<input type='hidden' name='lost_or_Adjestment' value='" . $query[29] . "' />";
                                                //echo "<input type='hidden' name='received' value='" . $query[30] . "' />";
                                                //echo "<input type='hidden' name='issued' value='" . $query[31] . "' />";
                                                //echo "<input type='hidden' name='current_balance' value='" . $query[32] . "' />";


                                                echo'<tr><td>  <input type="submit" name="submit" value="Sell Prescription" /></td></tr>';
                                            } else
                                            $informDrugs="No Drug to recommed!!";
                                        } else
                                            $informDrugs="No Drug to recommed!!";
                                        ?>

                                    </tbody>
                                </table>


                            </form>
                        </td>
                        <!-- Sell With Out PREscription   -->

                        <td id="drugnamewithnoprescription">
                            <!--with prescription -->
                            <form name="sellDrugwithnoprescription" action="selldrug.php" method="POST" >
                                <table   cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th>Select Specific Drug</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Drug Name</td>
                                            <td>
                                                <select name="drugname" contenteditable="true" title="Drug Name">
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    //$presdate=$_SESSION['presdate'];//presdate
                                                    if ($result = mysqli_query($con, "select distinct ProductName from drug_detail where current_balance>0 and  Exp_date>NOW();")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['ProductName'] . "' label='" . $query['ProductName'] . "'></option>";
                                                        }
                                                        echo'<input type="submit" name="submit" value="Submit specific Drug" /> </td>';
                                                    }
                                                    ?>
                                                </select>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </td>

                        <td id="sellwithout">

                            <!--   sell with prescription lastly-->
                            <form name="sell" action="selldrug.php" method="POST" >
                                <table   cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th><b></b></th>

                                        </tr>
                                    </thead>
                                    <tbody>

<?php
$con = mysqli_connect("localhost", "root", "prescription", "prescription");
if ($result = mysqli_query($con, "select Cost,Product_Name from drug_detail,drug where drug_detail.ProductName='" . $drug . "' and drug_detail.ProductName=drug.Product_Name and current_balance>0 and drug_detail.Exp_date > Now() ORDER BY Exp_date ASC")) {

    if (mysqli_num_rows($result) > 0) {
        $r = mysqli_query($con, "select SUM(current_balance) as quantity from drug_detail where drug_detail.ProductName='" . $drug . "' and current_balance>0 and drug_detail.Exp_date > Now() ORDER BY Exp_date ASC");
        $max = mysqli_fetch_array($r);
        $maxquantity = $max['quantity'];
        echo"<td>Quantity</td><td> <select name = 'quantity' required='required'> Label='select Quantity'";
        for ($i = 1; $i <= $maxquantity; $i++) {
            echo "<option value='$i'> $i</option>";
        }

        echo "</select>";
        echo("<tr><td>Tax</td><td>");
        $query = mysqli_fetch_array($result);
        echo "<input type='number' max='1' min='0' name='tax' step='any' value='0' title='Enter tax Ratio'/></td></tr>";
        echo "<input type='hidden' name='cost' value='" . $query['Cost'] . "' />";
        echo "<input type='hidden' name='drug' value='" . $query['Product_Name'] . "' />";
        echo'<tr><td>  <input type="submit" name="submit" value="Sell Drug" /></td></tr>';
    } else
        $informDrugs="No Drug to Sell!";
} else
    $informDrugs="No Drug to Sell!";
?>

                                    </tbody>
                                </table>


                            </form>
                        </td>
                        <!-- sell without Prescription ends here-------------------------------------->
                    </tr>
                </tbody>
            </table>
            <div class="clear"> </div>
        </div>
        <div class="clear"> </div>
    </div>
</div>

<?php
include_once 'footer.php';
if (!isset($_POST['submit'])) {
    echo'<script type="text/javascript">
    document.getElementById("sell").style.display = "none";
    document.getElementById("sellDrugwithprescription").style.display = "none";
    document.getElementById("sellwithout").style.display = "none";
    document.getElementById("drugnamewithnoprescription").style.display = "none";
</script> ';
}
if (isset($_POST['submit']) && ($_POST['submit'] == "Prescription Of the Date") && $_POST['choice'] == "with") {
    echo'<script type="text/javascript">
    document.getElementById("sellDrug").style.display = "none";
    document.getElementById("sell").style.display = "none";
    document.getElementById("sellwithout").style.display = "none";
    document.getElementById("drugnamewithnoprescription").style.display = "none";
</script> ';
}

if (isset($_POST['submit']) && $_POST['submit'] == 'Submit specific Prescription') {
    echo'<script type="text/javascript">
    document.getElementById("sellDrug").style.display = "none";
    document.getElementById("sellDrugwithprescription").style.display = "none";
    document.getElementById("sellwithout").style.display = "none";
    document.getElementById("drugnamewithnoprescription").style.display = "none";
</script> ';
}
if (isset($_POST['submit']) && ($_POST['submit'] == "Sell Prescription")) {
    echo'<script type="text/javascript">
    document.getElementById("sell").style.display = "none";
    document.getElementById("sellDrugwithprescription").style.display = "none";
    document.getElementById("sellwithout").style.display = "none";
    document.getElementById("drugnamewithnoprescription").style.display = "none";
</script> ';
}
/*
 * Hide forms when choosing to sell without prescription begins here
 */
if (isset($_POST['submit']) && ($_POST['submit'] == "Prescription Of the Date") && $_POST['choice'] == "without") {
    echo'<script type="text/javascript">
    document.getElementById("sellDrug").style.display = "none";
    document.getElementById("sell").style.display = "none";
    document.getElementById("sellDrugwithprescription").style.display = "none";
    document.getElementById("sellwithout").style.display = "none";
    document.getElementById("drugnamewithnoprescription").style.display = "";
</script> ';
}

if (isset($_POST['submit']) && ($_POST['submit'] == "Submit specific Drug")) {
    echo'<script type="text/javascript">
    document.getElementById("sellDrug").style.display = "none";
    document.getElementById("sell").style.display = "none";
    document.getElementById("sellDrugwithprescription").style.display = "none";
    document.getElementById("sellwithout").style.display = "none";
    document.getElementById("drugnamewithnoprescription").style.display = "none";
    document.getElementById("sellwithout").style.display = "";
    </script> ';
}
if (isset($_POST['submit']) && ($_POST['submit'] == "Sell Drug")) {
    echo'<script type="text/javascript">
    document.getElementById("sellDrug").style.display = "none";
    document.getElementById("sell").style.display = "none";
    document.getElementById("sellDrugwithprescription").style.display = "none";
    document.getElementById("sellwithout").style.display = "none";
    document.getElementById("drugnamewithnoprescription").style.display = "none";
    document.getElementById("sellwithout").style.display = "";
    </script> ';
}
/*
 * Hide forms when choosing to sell without prescription ends here
 */
?>
