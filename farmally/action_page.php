<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FarmAlly</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
</head>
<body style="background-image: url(images/background.jpg);">
<?php
$servername="localhost";
$username="root";
$password="";//"root123";
$dbname="farmally";
$a=[];
//Create connection
$conn=mysqli_connect($servername,$username,$password,$dbname);
//check connection stats
if($conn->connect_error)
die("connection failed".$conn->error);
$sql  = "SELECT * FROM student";
$result = $conn->query($sql);
echo "<center>The original table :</center>";
echo "<br>";
echo "<table border='2'>";
echo "<tr>";
echo "<th>USN</th><th>Name</th><th>Address</th></tr>";
if($result->num_rows > 0){
while($row=$result->fetch_assoc()){  
  echo "<tr><td>".$row["usn"]."</td><td>".$row["name"]."</td><td>".$row["address"]."</td></tr>";
  array_push($a,$row["usn"]);
}
echo "</table>";
}
else{
   echo "Table is empty";
   echo "</table>";
}
$b=[];
$c=[];
$n=count($a);
// insertion sort
for($i=0;$i<($n-1);$i++){
     $pos=$i;
    for($j=$i+1;$j<$n;$j++){
        if($a[$pos]>$a[$j])
         $pos=$j;
    }
    if($pos==$i){
        //swap
        $temp=$a[$pos];
        $a[$pos]=$a[$i];
        $a[$i]=$temp;
    }
}
$result=$conn->query($sql);
while($row=$result->fetch_assoc()){
    for($i=0;$i<$n;$i++){
        if($row["usn"]==$a[$i]){
            $b[$i]=$row["name"];
            $c[$i]=$row["address"];
        }
    }
}
echo "<br><br><center>Sorted Table</center>";
echo "<table>";
for($i=0;$i<$n;$i++){
    echo "<tr><td>".$a[$i]."</td><td>".$b[$i]."</td><td>".$c[$i]."</td></tr>";
}
echo "</table>";
$conn->close();
?>
</body>
</html>