
<?php
$msg = "";
include 'header.php';
if (isset($_POST['submit'])) {

    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    $uname = $_POST['uname'];
    $pswd = $_POST['pswd'];
    $privilege = $_POST['privilege'];
    $name = $_POST['name'];
    $eid = $_POST['eid'];
    if ($result = mysqli_query($con, "select* from Account where uname='$uname'")) {
        $query = mysqli_fetch_array($result);
        if (mysqli_num_rows($result) == 1)
            $msg = "Already an account with this User Name";
        else {
            $query = "INSERT INTO `account`(`Uname`, `Password`, `Eid`, `privillage`, `FullName`, `Date_Created`, `Status`) VALUES ('$uname','$pswd','$eid','$privilege','$name',NOW(),1);";
            $query2 = "INSERT INTO `account_status`(`Username`, `Reason`, `Timestamp`, `Status`) VALUES ('$uname','Account Created',NOW(),1);";
            if (mysqli_query($con, $query) && mysqli_query($con, $query2))
                $msg = "Account Created Successfully";
            else {
                $msg = "can't create account" . mysql_errno();
            }
            // header('Location:pharmacy.php');
        }
    }
}
?>



<div class="wrap" style="height:100%" >
    <div class="content">
        <div class="grids" style="alignment-adjust: central">

            <form style="border: #0f6d75 solid thick; display: block" name="register" action="register.php" method="POST">

                <table  cellspacing="2">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>User Name</td>
                            <td><input  title="Minimum of 6 alpha numeric and combination of ><=,!@().-*_&^%$~" pattern="[a-zA-Z0-9><=,!@().*_&^%$~]{6,}" placeholder="user name" required="required" autofocus="autofocus" type="text" name="uname" value="" /></td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input title="Minimum of 6 alpha numeric and combination of ><=,!@().-*_&^%$~" pattern="[a-zA-Z0-9><=,!@().*_&^%$~]{6,}" placeholder="Password" required="required" autofocus="autofocus" type="password" name="pswd" value="" /></td>

                        </tr>
                        <tr>
                            <td>Employee ID</td>
                            <td><input placeholder="Employee ID" required="required" autofocus="autofocus" type="text" name="eid" value="" /></td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td><input placeholder="Employee full name" pattern="[A-Za-z- ]{3,}" required="required" autofocus="autofocus" type="text" name="name" value="" /></td>
                        </tr>
                        <tr>
                            <td>Privilege</td>
                            <td>
                                <select name="privilege">
                                    <?php
                                    if ($_SESSION['privillage'] == 'HC Manager') {
                                        $ms = <<<R
                                <option value="Doctor" spellcheck="true" label="Doctor" ></option>
                                <option value="HC Manager" spellcheck="true" label="Health center Manager" ></option>
R;
                                    }
                                    else if ($_SESSION['privillage'] == 'Pharmacy Manager'){
                                        $ms = <<<R
                                
                                <option value="Pharmacy Manager"  label="Pharmacy Manager" ></option>
                                <option value="Pharmacist"  label="Pharmacist" ></option>
R;
                                    echo $ms;
                                    }
                                    ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="color: red; font-size: large"><?php
                                    echo $msg;
                                    ?></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" value="Create" name="submit" value="submit" />
            </form>  

            <div class="clear"> </div>
        </div>
        <div class="clear"> </div>
    </div>
</div>




<?php
include_once 'footer.php';
?>