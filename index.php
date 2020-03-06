<html>
<head>
    <meta charset="UTF-8" />
    <title>
        Polskie Ognisko | Bany na BLU
    </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
table {
border-collapse: collapse;
width: 100%;
color: #3473c1;
font-family: monospace;
font-size: 25px;
text-align: left;
}
th {
background-color: #211f1f;
color: white;
}
tr:nth-child(even) {background-color: #211f1f}
</style>
</head>
<body style='background-color:#0a0a0a'>
<form action="profile.php" method="post">  
  <input placeholder="Nick Gracza" type="text" name="search"><br>  
  <input type="submit">
</form>   
<table height="70%">
<tr>
<th  class="th-sm">Nick</th>
<th  class="th-sm">Czas</th>
<th  class="th-sm">Nick Admina</th>
</tr>

<?php
 if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $conn=mysqli_connect("localhost","user","pass","db_name");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql = "SELECT COUNT(*) FROM tf2jr_guardbans_logs";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT offender_name,bantime,admin_name FROM tf2jr_guardbans_logs ORDER BY timestamp DESC LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($res_data)){
            if($row["bantime"]==0){
				echo "<tr><td><span style='color:#0b8700;text-align:center;'>". $row["offender_name"]. "</span> </td><td>". "<span style='color:#ff0000;text-align:center;'>Permanentnie</span>". "</td><td><span style='color:#4287f5;text-align:center;'>" . $row["admin_name"] . "</span></td></tr>";
			}
			else{
				echo "<tr><td><span style='color:#0b8700;text-align:center;'>". $row["offender_name"]. "</span> </td><td><span style='color:#fcba03;text-align:center;'>". $row["bantime"]. " min</span> </td><td><span style='color:#4287f5;text-align:center;'>" . $row["admin_name"] . "</span></td></tr>";
			}
        }
        mysqli_close($conn);
?>
</table>
    <ul class="pagination">
        <li><a href="?pageno=1">Pierwsza strona</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Wstecz</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Dalej</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Ostatnia strona</a></li>
    </ul>
</body>
</html>