
<?php
$msg = "";
include 'header.php';
if (isset($_POST['submit'])) {
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
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
    else if (mysqli_num_rows(mysqli_query($con, "select* from drug_detail where batch_No='" . $_POST['pbatch'] . "'")) == 0) {
       $pbalance = $_POST['preceived']- ($_POST['pissued'] + $_POST['plostoradj']);
       $query = "INSERT INTO `drug_detail`(`batch_No`, `ProductName`, `receiving_Date`, `Exp_date`, `MFG_Date`, `lost_or_Adjestment`, `received`,`issued`, `current_balance`, `remark`)" .
                " values ('" . $_POST['pbatch'] . "','" . $_POST['pname'] . "','" . $_POST['prdate'] . "','" . $_POST['pedate'] . "','" . $_POST['pmdate'] . "'," . $_POST['plostoradj'] . "," . $_POST['preceived'] . "," . $_POST['pissued'] . "," . $pbalance . ",'" . $_POST['premark'] . "')";
        if (mysqli_multi_query($con, $query))
            $msg = "Drug Added Successfully";
        else {
            $msg = "can't record Drug" . mysqli_error($con);
        }
        // header('Location:pharmacy.php');
    } else
        $msg = "Already a drug with this Batch No";
}
?>



<div class="wrap" style="height:100%" >
    <div class="content">
        <div class="grids">
            <span style="color:red">
                <?php
                echo $msg;
                ?>
            </span>
            <form name="newdrug" action="moredrug.php" method="POST" >    

                <table border="1" width="100%" cellspacing="1">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
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
                                            <td>Drug Name</td> 
                                            <td><select name="pname">
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select Product_Name from drug")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['Product_Name'] . "' label='" . $query['Product_Name'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td></tr>
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
                                            <td><input type="date" name="prdate" value=""  /></td>
                                        </tr>
                                        <tr>
                                            <td>Expiry Date</td>
                                            <td><input type="date" name="pedate" value="" required="required" min="<?php echo date('Y-m-d') . 'T' . date('H:i'); ?>"/></td>
                                        </tr>

                                        <tr>
                                            <td>Lost Or Adjustment</td>
                                            <td><input type="number" name="plostoradj" value="0" min="0"/></td>
                                        </tr>
                                        <tr>
                                            <td>Received</td>
                                            <td><input type="number" name="preceived" min="0"/></td>
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
                                                <input type="submit" name="submit" label="Update Drug Detail" />
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
