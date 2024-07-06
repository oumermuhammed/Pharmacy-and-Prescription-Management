
<!DOCTYPE HTML>
<?php
$msg = "";
session_start();
if (isset($_POST['submit'])) {

    $con = mysqli_connect("localhost", "root", "prescription", "prescription");
    $uname = $_POST['uname'];
    $pswd = $_POST['pswd'];
    if ($result = mysqli_query($con, "select* from account where uname='$uname' and password='$pswd'")) {
        $query = mysqli_fetch_array($result);
        if (mysqli_num_rows($result) == 1) {
            if ($query['Status'] == true) {

                $_SESSION['uname'] = $uname;
                $_SESSION['name'] = $query['FullName'];
                
                $_SESSION['privillage'] = $query['privillage'];
                header('Location:index.php');
            }
            else
                $msg = "Account deactivated";

                
        } else {

            $msg = "Login Name or Password Incorrect";
            // header('Location:pharmacy.php');
        }
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
                <div class="logo">
                    <h1 style="color: #F0F0F0;font-size: x-large">Prescription Management System </h1>
                </div>
                <div class="contact-info">
                    <ul>
                        <li></li>
                        <li></li>
                        <li> </li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <div class="clear"> </div>
            </div>
        </div>
        <div class="clear"> </div>


        <div class="clear"> </div>
        <!--start-image-slider---->

        <!--End-image-slider---->
        <div class="clear"> </div>

        <br>

        <div class="wrap" style="height:100%" >
            <div class="content">
                <div class="grids" style="alignment-adjust: central">

                    <form style="border: #0f6d75 solid thick; display: block" name="login" action="login.php" method="POST">

                        <table border="0" style="font-size: larger">

                            <tbody>
                                <tr>
                                    <td> User Name</td>
                                    <td><input title="User Name" required="required" placeholder="User Name" autofocus="autofocus" type="text" name="uname" value="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>password</td>
                                    <td><input  type="password" name="pswd" value="" /></td>
                                </tr>

                                <tr>

                                    <td></td>
                                    <td> </td>
                                </tr>
                                <tr>

                                    <td style="color:red">
                                        <?php
                                        echo $msg;
                                        ?></td>
                                    <td> <input   style="background: #0f6d75;color:white" type="submit" name="submit" value="Login"/></td>
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