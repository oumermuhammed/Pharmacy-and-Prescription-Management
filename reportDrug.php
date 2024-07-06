
<?php
include 'header.php';
$batch = "";
$ProductName = "";
$msg = "";
if (isset($_POST['submit'])) {
    if (isset($_POST['submit']) && $_POST['submit'] == 'Submit Batch') {
        $batch = $_POST['batch'];
        // prescription sell
    }
    if (isset($_POST['submit']) && $_POST['submit'] == 'Submit specific product') {
        $ProductName = $_POST['ProductName'];
        // prescription sell
    }



    if (isset($_POST['submit']) && ($_POST['submit'] == "Update Drug Information" )) {
        $con = mysqli_connect("localhost", "root", "prescription", "prescription");
        $quantity = $_POST['quantity'];
        $remark = $_POST['remark'];
        $batch = $_POST['batch'];

// Update Drug detail of Damaged Drug with specific Batch No.
        $updateDetail = "update drug_detail set lost_or_Adjestment=$quantity ,current_balance=(current_balance-$quantity), remark='$remark' where batch_No='" . $_POST['batch'] . "'";
        if (!mysqli_query($con, $updateDetail))
            echo "Can't Update Drug Details " . mysqli_error($con);
        else {
            echo "<span style='color:green;font-size:x-large'>Drug Detail Updated!!</span>";
        }
        //end update drug detail
    }
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


            <span style="color:red">
                <?php
                echo $msg;
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

                        <td id="selectproduct">
                            <!--with prescription -->
                            <form name="selectProduct" action="reportDrug.php" method="POST" >
                                <table   cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th>Select Drug Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Drug Name</td> 
                                            <td><select name="ProductName">
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select ProductName from drug_detail where current_balance>0 and Exp_date>NOW();")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['ProductName'] . "' label='" . $query['ProductName'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td></tr>


                                    </tbody> 
                                </table>
                                <input type="submit" name="submit" value="Submit specific product" />
                            </form>
                        </td>
                        <td id="batch">

                            <!-- with prescription and sell lastly-->
                            <form name="batch" action="reportdrug.php" method="POST" >
                                <table   cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th><b></b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Batch Number</td>
                                            <td>
                                                <select name="batch">
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    //$presdate=$_SESSION['presdate'];//presdate
                                                    if ($result = mysqli_query($con, "select batch_No from drug_detail where ProductName='" . $ProductName . "' and current_balance>0 and Exp_date>NOW();")) {
                                                        while ($query = mysqli_fetch_array($result)) {
                                                            echo "<option value='" . $query['batch_No'] . "' label='" . $query['batch_No'] . "'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <input type="submit" name="submit" value="Submit Batch" />
                            </form>
                        </td>
                        <td id="quantity">

                            <!-- with prescription and sell lastly-->
                            <form name="quantityform" action="reportdrug.php" method="POST" >
                                <table   cellspacing="1">
                                    <thead style="font-size: larger">
                                        <tr>
                                            <th></th>
                                            <th><b></b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Lost Or Damager Quantity</td>
                                            <td>
                                                <select name="quantity" required="required">
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    //$presdate=$_SESSION['presdate'];//presdate
                                                    if ($result = mysqli_query($con, "select current_balance from drug_detail where batch_No='" . $batch . "'")) {
                                                        $query = mysqli_fetch_array($result);
                                                        for ($i = 1; $i <= $query['current_balance']; $i++) {
                                                            echo "<option value='$i' label='$i'></option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                    <?php
                                                    echo "<input type='hidden' name='batch' value='" . $batch . "'/>";
                                                    ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Reason</td>
                                            <td><textarea name="remark" required></textarea></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <input type="submit" name="submit" value="Update Drug Information"/>
                            </form>
                        </td>
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
    document.getElementById("batch").style.display = "none";
    document.getElementById("quantity").style.display = "none";
</script> ';
}
if (isset($_POST['submit']) && ($_POST['submit'] == "Submit Batch")) {
    echo'<script type="text/javascript">
    document.getElementById("selectproduct").style.display = "none";
    document.getElementById("batch").style.display = "none";
</script> ';
}
if (isset($_POST['submit']) && ($_POST['submit'] == "Update Drug Information" )) {
    echo'<script type="text/javascript">
    document.getElementById("batch").style.display = "none";
    document.getElementById("selectproduct").style.display = "none";
</script> ';
}
if (isset($_POST['submit']) && ($_POST['submit'] == "Submit specific product")) {
    echo'<script type="text/javascript">
    document.getElementById("selectproduct").style.display = "none";
    document.getElementById("quantity").style.display = "none";
</script> ';
}
?>