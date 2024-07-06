
<?php
include 'header.php';
?>
<br>
<style>
table {
    border-collapse: collapse;
    width: 40%;
    vertical-align: middle;
}

table, td {
    border: 3px solid #0160A4;
}
th{
    border: 5px solid #FF8400;
}
</style>
<table >
    <thead>
        <tr >
            <th>Product Name</th>
            <th>Batch Number</th>
            <th>Expiry Date</th>
        </tr>
    </thead>
    <tbody>



        <?php
        $query = "SELECT `ProductName`,batch_No,`Exp_date` FROM `drug_detail` WHERE drug_detail.exp_date< (CURDATE() + INTERVAL 15 DAY)";
        $con = mysqli_connect("localhost", "root", "prescription", "prescription");
        $result = mysqli_query($con, $query);
        while ($r = mysqli_fetch_array($result)) {
            echo "<tr>
            <td>".$r['ProductName']."</td><td>".$r['batch_No']."</td><td>".$r['Exp_date']."</td></tr>";
        }
        ?>

    </tbody>
</table>
<br><br><br>
<?php
        include 'footer.php';
?>