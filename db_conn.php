<?php
require('db_prop.php');
require('models/User.php');
class DB
{
  public $table;
  public $column;
  public $where;
  public $order;
  public $join;
}
class DBinsert extends DB
{
  public $value;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {

  die("Connection failed: " . $conn->connect_error);
}




function insert($conn, $query)
{


  $sql = "INSERT INTO $query->table $query->column
                              VALUES ($query->value)";

  var_dump($sql);

  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    return false;
  }

  // $conn->close();
}
function select($conn, $query)
{
  $arrQuery = array();
  if ($query->where != null) {
    $sql = "SELECT $query->column FROM $query->table where $query->where";
    // var_dump($sql);
  } else {
    $sql = "SELECT $query->column FROM $query->table";
  }

  // var_dump($sql);
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      // echo "id: " . $row["id"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] . "<br>";
      $tempUser = new User();
      $tempUser->id = $row['id'];
      $tempUser->name = $row['name'];
      $tempUser->email = $row['email'];
      $tempUser->city = $row['city'];
      $tempUser->role = $row['role'];

      array_push($arrQuery, $tempUser);
    }
    return $arrQuery;
  } else {
    return 0;
  }
}
function update()
{
  
}
function delete()
{
}



$query = new DBinsert();
$query->table = "user";
$query->column = "(name,email,city,role)";
$query->value = "'name1','name@gmail.com','Kolumpur',1";


//insert($conn, $query);
$sql = new DB();
$sql->table = "user";
$sql->column = "*";
$sql->where = "id = 3";

$user = select($conn, $sql);
// var_dump($user);
foreach ($user as $value) {
  echo $value->id;
  echo $value->name;
}
