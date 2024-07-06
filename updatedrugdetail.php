
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
            <form name="updatedrug" action="updatedrugdetail.php" method="POST" >    

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
                                            <td>Drug Name</td> 
                                            <td>
                                                <select name="pname" onchange="document.updatedrug.submit();" required="required" >
                                                    <option>--</option>
                                                    <?php
                                                    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
                                                    if ($result = mysqli_query($con, "select Product_Name from drug where Uname='" . $_SESSION['uname'] . "'")) {
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
                                                <input type="text" name="type" autofocus="autofocus" value=""  required="required"/> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dosage Form</td>
                                            <td> 
                                                <input type="text" name="dosageform"  required="required" value="" /> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Manufacturer</td>
                                            <td><input title="enter Manufacturer" pattern="[a-zA-Z0-9- ]{5,}" placeholder="Manufacturer company" type="text" name="manufacturer" value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Cost</td>
                                            <td><input  required="required" autofocus="autofocus" type="number" name="cost" step='any' value="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Root Of Admin</td>
                                            <td>
                                                <input type="text" name="rootofadmin"  value="" />
                                            </td>
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
                                            <td>Unit of Issue Quantity</td>
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
                                            <td><input type="submit" name="update" value="Update Drug" />
                                            </td>
                                            <td id="msg"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!--drug detail-->

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
if (isset($_POST['pname']) && $_POST['pname'] != "--" && !(isset($_POST['update']))) {
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    if ($result = mysqli_query($con, "select distinct * from drug where Product_Name='" . $_POST['pname'] . "'")) {
        $query = mysqli_fetch_array($result);
        $type = $query['Type'];
        $Dosage_Form = $query['Dosage_Form'];
        $Manufacturer = $query['Manufacturer'];
        $Cost = $query['Cost'];
        $Root_Of_Admin = $query['Root_Of_Admin'];
        $Strength = $query['Strength'];
        $Unit_Of_Issue = $query['Unit_Of_Issue'];
        $Quantity = $query['Quantity'];
        $least_Unit = $query['least_Unit'];
        $Each_quantity = $query['Each_quantity'];
        $pname = $_POST['pname'];
        $show = <<<ASSIGN
        <script type="text/javascript">
            document.updatedrug.pname.value='$pname';
            document.updatedrug.type.value='$type';
            document.updatedrug.dosageform.value='$Dosage_Form';
            document.updatedrug.manufacturer.value='$Manufacturer';
            document.updatedrug.cost.value='$Cost';
            document.updatedrug.rootofadmin.value='$Root_Of_Admin';
            document.updatedrug.pstrength.value='$Strength';
            document.updatedrug.uissue.value='$Unit_Of_Issue';
            document.updatedrug.pquantity.value='$Quantity';
            document.updatedrug.plunit.value='$least_Unit';
            document.updatedrug.plquantity.value='$Each_quantity';
        </script>   
ASSIGN;
        echo $show;
    }
} else if (isset($_POST['pname']) && $_POST['pname'] != "--" && (isset($_POST['update']))) {
    $Type = $_POST['type'];
    $Dosage_Form = $_POST['dosageform'];
    $Manufacturer = $_POST['manufacturer'];
    $Cost = $_POST['cost'];
    $Root_Of_Admin = $_POST['rootofadmin'];
    $Strength = $_POST['pstrength'];
    $Unit_Of_Issue = $_POST['uissue'];
    $Quantity = $_POST['pquantity'];
    $least_Unit = $_POST['plunit'];
    $Each_quantity = $_POST['plquantity'];
    $pname = $_POST['pname'];
    $query = "update drug set Type='" . $Type . "', Dosage_Form='" . $Dosage_Form . "', Manufacturer='" . $Manufacturer . "',Cost=" . $Cost .
            ",Root_Of_Admin='" . $Root_Of_Admin . "',Strength='" . $Strength . "',Unit_Of_Issue='" . $Unit_Of_Issue . "',Quantity=" . $Quantity . ",least_Unit='" . $least_Unit .
            "',Each_quantity=" . $Each_quantity . " where Product_Name='" . $pname . "'";
    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    if ($result = mysqli_query($con, $query)) {
        $show = <<<ASSIGN
        <script type="text/javascript">
                document.getElementById("msg").innerHTML="<span style='color: #22aa11;font-size:larger'> Successfully Updated!</span>";

        </script>   
ASSIGN;
        echo $show;
    } else{
        $show = <<<ASSIGN
        <script type="text/javascript">
                document.getElementById("msg").innerHTML="<span style='color: #aa1111;font-size:larger'> Update Failed!</span>";
        </script>   
ASSIGN;
        echo $show;  
        }
}
?>

<script type="text/javascript">

<?php
include_once 'footer.php';
?>
