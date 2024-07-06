
<?php
$msg = "";
include 'header.php';
if (isset($_POST['submit'])) {
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    $ptype = ($_POST['ptype'] == "Other") ? $_POST['new'] : $_POST['ptype'];
    $pform = ($_POST['pform'] == "Other") ? $_POST['newdosage'] : $_POST['pform'];
    $proot = ($_POST['proot'] == "Other") ? $_POST['newadmin'] : $_POST['proot'];
    $Product_Name = $_POST['pname'];
    if ($_POST['pedate'] <= date('Y-m-d')) {
        $msg = "Entering Expired Product Not Allowed";
    } else if ($_POST['pmdate'] > date('Y-m-d')) {
        $msg = "Manufactured Date is error";
    } else if ($_POST['plostoradj'] == 0 && $_POST['preceived'] == 0 && $_POST['pissued'] == 0) {
        $msg = "Enter either Received, Issued or Lost ";
    } else if ($_POST['prdate'] > date('Y-m-d')) {
        $msg = "Receiving Date is Greater than today";
    } else if ($_POST['pedate'] <= $_POST['pmdate']) {
        $msg = "Manufactured Date and Expiry Date Unsatisafieble";
    } else if ($_POST['prdate'] < $_POST['pmdate']) {
        $msg = "Manufactured Date and Receiving Date Unsatisafieble";
    }
    else if ($_POST['preceived'] < ($_POST['pissued'] + $_POST['plostoradj'])) {
        $msg = "Received must be greater or equal to (lost+Issued)";
    }
    if (mysqli_num_rows(mysqli_query($con, "select* from drug where Product_Name='" . $Product_Name . "'")) == 0) {
        if (mysqli_num_rows(mysqli_query($con, "select* from drug_detail where batch_No='" . $_POST['pbatch'] . "'")) == 0) {
            $pbalance = $_POST['preceived'] - $_POST['pissued'] - $_POST['plostoradj'];
            $query = "INSERT INTO `drug`(`Product_Name`, `Type`, `Dosage_Form`, `Manufacturer`, `Cost`, `Root_Of_Admin`, `Strength`, `Unit_Of_Issue`, `Quantity`, `least_Unit`, `Each_quantity`, `Uname`) VALUES" .
                    "('" . $_POST['pname'] . "','" . $ptype . "','" . $pform . "','" . $_POST['pmanufacturer'] . "'," . $_POST['pcost'] . ",'" . $proot . "','" . $_POST['pstrength'] . "','" . $_POST['pissued'] . "'," . $_POST['pquantity'] . ",'" . $_POST['plunit'] . "'," . $_POST['plquantity'] . ",'" . $_SESSION['uname'] . "');";
            $query.= "INSERT INTO `drug_detail`(`batch_No`, `ProductName`, `receiving_Date`, `Exp_date`, `MFG_Date`, `lost_or_Adjestment`, `received`,`issued`, `current_balance`, `remark`)" .
                    " values ('" . $_POST['pbatch'] . "','" . $_POST['pname'] . "','" . $_POST['prdate'] . "','" . $_POST['pedate'] . "','" . $_POST['pmdate'] . "'," . $_POST['plostoradj'] . "," . $_POST['preceived'] . "," . $_POST['pissued'] . "," . $pbalance . ",'" . $_POST['premark'] . "')";
            if (mysqli_multi_query($con, $query))
                $msg = "Drug Recorded Successfully";
            else {
                $msg = "can't record Drug" . mysqli_error($con);
            }
            // header('Location:pharmacy.php');
        } else
            $msg = "Already a drug with this batch No";
    } else
        $msg = "Already a drug with this Name";
}
?>

<script type="text/javascript">
    function activate(selection, other) {


        if (selection.value === "Other")
            other.removeAttribute('disabled');
        else
            other.disabled = "true";
    }
</script>

<div class="wrap" style="height:100%" >
    <div class="content">
        <div class="grids">
            <span style="color: red"><?php
echo $msg;
?>
            </span>
            <form name="newdrug" action="drug.php" method="POST" >    

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
                                            <th><b>Drug Basic Information</b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Product Name</td>
                                            <td><input required="required" pattern="[a-zA-Z0-9- ]{5,}" placeholder="Drug Name" type="text" name="pname" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Drug Type</td>
                                            <td>
                                                <select name="ptype" onchange="activate(this, document.newdrug.new)">
<?php
$con = mysqli_connect("localhost", "root", "prescription", "prescription");
if ($result = mysqli_query($con, "select Type from drug")) {
    while ($query = mysqli_fetch_array($result)) {
        echo "<option value='" . $query['Type'] . "' label='" . $query['Type'] . "'></option>";
    }
}
?>
                                                    <option value="Other" label="Other"></option>    <option value="Other" label="Other"></option>           
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td>New Type</td>
                                            <td><input type="text" name="new"  value="" disabled="true" /></td></tr>
                                        <tr>
                                            <td>Dosage Form</td>
                                            <td>
                                                <select name="pform" onchange="activate(this, document.newdrug.newdosage)">
<?php
$con = mysqli_connect("localhost", "root", "prescription", "prescription");
if ($result = mysqli_query($con, "select Dosage_Form from drug")) {
    while ($query = mysqli_fetch_array($result)) {
        echo "<option value='" . $query['Dosage_Form'] . "' label='" . $query['Dosage_Form'] . "'></option>";
    }
}
?>
                                                    <option value="Other" label="Other"></option>     <option value="Other" label="Other"></option>       
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td>New Dosage Form</td>
                                            <td><input type="text" name="newdosage"  value="" disabled="true" /></td>
                                        </tr>

                                        </tr>
                                        <tr>
                                            <td>Manufacturer</td>
                                            <td><input title="enter Manufacturer" pattern="[a-zA-Z0-9- ]{5,}" placeholder="Manufacturer company" type="text" name="pmanufacturer" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Cost</td>
                                            <td><input  required="required" autofocus="autofocus" type="number" name="pcost" step='any' value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Root Of Admin</td>



                                            <td>
                                                <select name="proot" onchange="activate(this, document.newdrug.newadmin)">
<?php
$con = mysqli_connect("localhost", "root", "prescription", "prescription");
if ($result = mysqli_query($con, "select Root_Of_Admin from drug")) {
    while ($query = mysqli_fetch_array($result)) {
        echo "<option value='" . $query['Root_Of_Admin'] . "' label='" . $query['Root_Of_Admin'] . "'></option>";
    }
}
?>
                                                    <option value="Other" label="Other"></option>   <option value="Other" label="Other"></option>    
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td>New Root Of Admin</td>
                                            <td><input type="text" name="newadmin"  value="" disabled="true" /></td></tr>

                                        </tr>
                                        <tr>
                                            <td>Strength</td>
                                            <td><input type="text" required="required" name="pstrength" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Unit of Issue</td>
                                            <td><input type="text" required="required" name="uissue" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Quantity</td>
                                            <td><input required="required" autofocus="autofocus" type="number" name="pquantity" value="" min="0"/></td>
                                        </tr>
                                        <tr>
                                            <td>Least Unit</td>
                                            <td><input placeholder="Least unit for each Unit of Issue" autofocus="autofocus" type="text" name="plunit" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Each Quantity</td>
                                            <td><input required="required" autofocus="autofocus" type="number" name="plquantity" value="" min="0"/></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--drug detail-->

                            </td>
                            <td>

                                <table  width="50" cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th>Drug Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Batch No</td>
                                            <td><input type="text" pattern="[A-Za-z0-9-/]{10,11}"  name="pbatch" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Manufactured Date</td>
                                            <td><input type="date" name="pmdate" value="" required="required"/></td>
                                        </tr>
                                        <tr>
                                            <td>receiving_Date</td>
                                            <td><input type="date" name="prdate" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Expiry Date</td>
                                            <td><input type="date" name="pedate" value="" min="<?php echo date('Y-m-d') . 'T' . date('H:i'); ?>" required="required"/></td>
                                        </tr>

                                        <tr>
                                            <td>Lost Or Adjustment</td>
                                            <td><input type="number" name="plostoradj" value="0" min="0" /></td>
                                        </tr>
                                        <tr>
                                            <td>Received</td>
                                            <td><input type="number" name="preceived" value="0" min="0"/></td>
                                        </tr>
                                        <tr>
                                            <td>Issued</td>
                                            <td><input type="number" name="pissued" value="0" min="0"/></td>
                                        </tr>
                                        <tr>
                                            <td>Remark</td>
                                            <td><textarea name="premark" rows="4" cols="20" required="required">
                                                </textarea></td>
                                        </tr>
                                        <tr><td></td><td>
                                                <input type="submit" name="submit" label="Add new Drug" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
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
