
<!DOCTYPE HTML>
<?php
session_start();

$m = "";
if (!(isset($_SESSION['uname']))) {
    Header("Location:login.php");
}
?>

<?php
/* Expired Drug Notification before 15 Days */
if ($_SESSION['privillage'] == "Pharmacy Manager"|| $_SESSION['privillage'] == "Pharmacist"){

$query = "SELECT `ProductName`,batch_No,`Exp_date` FROM `drug_detail` WHERE drug_detail.exp_date< (CURDATE() + INTERVAL 15 DAY)";
$con = mysqli_connect("localhost", "root", "prescription", "prescription");
if (mysqli_num_rows(mysqli_query($con, $query)) > 0) {

    $m = "<span style=''> Some Products Expired<a href='notifier.php' style=';color:red;background-color:white' target='_blank'>Click to see &nbsp;&nbsp;&nbsp;</a></span>";
}
}
?>
<html>
    <head>
        <title>prescription Management System</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"  media="all" />

    </head>
    <body>


        <div class="header">
            <div class="wrap">
                <div class="moreinformation">
                    <ul>
                        <li><?php echo $m; ?></li>
                    </ul>
                </div>
                <div class="contact-info">
                    <ul>
                        <li style="color: #DDDDBB;text-transform: capitalize">
<?php
$loginmsg = "Welcome " . $_SESSION['name'] . "&nbsp;&nbsp;&nbsp:&nbsp; " . $_SESSION['privillage'];
echo $loginmsg;
?>
                        </li>                                  
                        <!--change password begin here-->
                        <li>
<?php
$changemsg = "";
$m == "";
?>
                            <span style='color:#dd3333;font-size: small' id="msgg">
                            </span>
                            <a href="#" id="changelink" style="color:#ffff99;font-size: small" onclick="showpswd(this);">Change password</a>
                            <span id="change" style="display:None">
                                <span id="changepswd" style="font-size: 12">

                                    <!--with prescription -->
                                    <form name="changepswd" action="changepassword.php" method="POST" >
                                        <table   cellspacing="1">
                                            <thead style="font-size: small">
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>New Password</td> 
                                                    <td><input type="password" name="newpswd" value="" required="required"/>
                                                    </td></tr>
                                                <tr>
                                                    <td>Confirm Password</td> 
                                                    <td><input type="password" name="confirmpswd" value="" required="required"/>
                                                    </td></tr>


                                            </tbody> 
                                        </table>
                                        <input type="submit" name="submit" value="Change Password" />
                                    </form>
                                </span>
                            </span>

<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'Change Password') {

    $uname = $_SESSION['uname'];
    $pswd = $_POST['newpswd'];
    $confirmpswd = $_POST['confirmpswd'];
    if ($pswd == $confirmpswd) {

        $updateDetail = "update account set password='" . $pswd . "'  where Uname='" . $uname . "'";
        $con = mysqli_connect("localhost", "root", "prescription", "prescription");
        if (!mysqli_query($con, $updateDetail))
            $changemsg = "Can't Change Password" . mysqli_error($con);
        else {
            $changemsg = "Changed!";
            $m = <<<M
                   <script type="text/javascript">
                 document.getElementsByID("changelink").style.display="None";
                  document.getElementsByID("change").style.display="display";
                </script>
M;
            echo $m;
        }
    } else {
        $changemsg = "Password Did Not match";
        $m = <<<M
                   <script type="text/javascript">
                document.getElementById("change").style.display = "";
                document.getElementById("changelink").style.display = "none";
                </script>
M;
        echo $m;
    }
}

$m = <<<M
                   <script type="text/javascript">
                document.getElementById("msgg").innerHTML = "$changemsg";
                </script>
M;
echo $m;
?>
                            <script type="text/javascript">

                                function showpswd(link) {

                                    document.getElementById("change").style.display = "";
                                    document.getElementById("changelink").style.display = "none";
                                }
                            </script>  
                        </li>
                        <!-- Password changing code ends here-->
                        <script type="text/javascript">

                            function logoutck() {
                                window.location.href = 'logout.php'
                            }
                        </script>

                        <li> 
                            <span style="background: #0f6d75;color:white;cursor: pointer" ONCLICK="logoutck();"/>Log Out</span>
                        </li>
                    </ul>
                </div>

                <div class="clear"> </div>
            </div>
        </div>
        <div class="clear"> </div>
        <!-- Menu -->
        <ul id="topnav">

            <li><a href="index.php">Home</a></li>
            
            <?php
            if ($_SESSION['privillage'] == "Doctor") {
                echo '<li><a href="prescription.php">Prescription</a>';
                echo '<span>
                        <a href="updateprescription.php">Update Prescription</a> 
                        <a href="viewprescription.php">View Prescription</a> 
                   </span>
                   </li>';
            }
            else if ($_SESSION['privillage'] == "HC Manager"){
                echo '<li><a href="viewprescription.php">Prescription</a></li>';
                echo '<li><a href="ManageAccount.php">Account</a>';
                echo '<span>
                            <a href="ManageAccount.php">Manage Account</a> 
                        <a href="register.php">Register Account</a> 
                     </span>
                     </li>';
            }
            else if ($_SESSION['privillage'] == "Pharmacy Manager"){
                echo '<li><a href="viewprescription.php">Prescription</a></li>';
                echo '<li><a href="ManageAccount.php">Account</a>';
                echo '<span>
                        <a href="ManageAccount.php">Manage Account</a> 
                        <a href="register.php">Register Account</a> 
                     </span>
                     </li>';
                echo '<li><a href="viewDrug.php">Drug</a>';
                echo '<span>
                        <a href="notifier.php">Expired Products</a> 
                        <a href="viewsolddrug.php">Sold Drugs</a> 
                     </span>
                     </li>';
            }
            else if ($_SESSION['privillage'] == "Pharmacist"){
                echo '<li><a href="viewprescription.php">Prescription</a></li>';
                echo '<li><a href="sellDrug.php">Sell Drug</a>';
               echo '<span>
                        <a href="drug.php">Add New Drug</a> ;
                        <a href="updatedrugdetail.php">Update Drug</a>;
                        <a href="viewDrug.php">View Drugs</a> 
                        <a href="viewsolddrug.php">Sold Drugs</a> 
                        <a href="reportDrug.php">Report Damaged Drug</a>;
                        <a href="moredrug.php">Add More Drug</a> 
                        <a href="notifier.php">Expired Products</a> 
                     </span>
                     </li>';
            }

            ?>

            </li>
            
            

           

        </ul>

        <div class="clear"> </div>
        <!--start-image-slider---->

        <!--End-image-slider---->
        <div class="clear"> </div>

