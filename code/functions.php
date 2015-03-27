<?php
$servername = "localhost";
$username = "root";
$password = "windows";
$dbname = "addressbook";


function Getlistofnames()
{
 $mysqli = new mysqli( $GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
if ($mysqli->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql= "SELECT firstname,lastname,id FROM addressbook ORDER by id desc";

    $result = $mysqli->query($sql);
    $row_cnt = $result->num_rows;

   if ($row_cnt > 0)
       {
        while ($row = mysqli_fetch_assoc($result))
            {
            echo "<div class = 'btnaddress'><p><a href = 'Index.php?page=address&action=show&id=".$row['id']."'>".$row['firstname']."               ".$row['lastname']."</a></p></div>";
            }
        }
        else {echo "No entries";}
 $mysqli->close();
}

function AddRecordfromPost()
{
 if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	$FirstName =  test_input($_POST['fname']);
	$LastName =  test_input($_POST['lname']);
	$Address =  test_input($_POST['address']);
	$Town =  test_input($_POST['town']);
    $Postcode = test_input($_POST['pcode']);
	$Phone = test_input($_POST['phone']);
	$Email =  test_input($_POST['email']);
    }
    $mysqli = new mysqli( $GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        if ($mysqli->connect_error)
            {
                die("Connection failed: " . $mysqli->connect_error);
            }
     $image = GetimagefromPost();
    $query = "INSERT INTO addressbook VALUES ('','$FirstName', '$LastName', '$Address','$Town','$Postcode','$Phone','$Email','$image' )";
        if ($result = $mysqli->query($query))
           {
            echo "New record created successfully";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=Index.php?page=address"> ';
           }
        else
            {
               echo "Error: " . $query . "<br>" . $mysqli->error;
            }
 $mysqli->close();
 }

function UpdateRecordfromPost()
{
 if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
	$FirstName =  test_input($_POST['fname']);
	$LastName =  test_input($_POST['lname']);
	$Address =  test_input($_POST['address']);
	$Town =  test_input($_POST['town']);
    $Postcode = test_input($_POST['pcode']);
	$Phone = test_input($_POST['phone']);
	$Email =  test_input($_POST['email']);
    $ID = ($_POST['idname']);
    }
    $mysqli = new mysqli( $GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        if ($mysqli->connect_error)
            {
                die("Connection failed: " . $mysqli->connect_error);
            }
    $image = GetimagefromPost();
    if ($image == "")
    {
         $query = "UPDATE addressbook SET    firstname='$FirstName',lastname='$LastName',street='$Address',town='$Town',PostCode='$Postcode',phone='$Phone',email='$Email' WHERE id='$ID'";
    } else
    {
    $query = "UPDATE addressbook SET    firstname='$FirstName',lastname='$LastName',street='$Address',town='$Town',PostCode='$Postcode',phone='$Phone',email='$Email',Photo='$image' WHERE id='$ID'";
    }
        if ($result = $mysqli->query($query))
           {
           echo "Updated record successfully";
           echo '<META HTTP-EQUIV="refresh" content="0;URL=Index.php?page=address"> ';
           }
        else
            {
               echo "Error: " . $query . "<br>" . $mysqli->error;
            }
 $mysqli->close();
 }






function GetRecord($id)
{
$mysqli = new mysqli( $GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
if ($mysqli->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql= "SELECT * from ".$GLOBALS['dbname']. " WHERE id=".$id;
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

    }
    else { $row = "";}
$mysqli->close();
    return $row;
}


function DeleteRecord($id)
{
$mybool;
$mysqli = new mysqli( $GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
if ($mysqli->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
// sql to delete a record
$sql = "DELETE FROM " .$GLOBALS['dbname']." WHERE id=".$id;
if ($mysqli->query($sql) === TRUE)
    { $mybool = true;}
    else { $mybool = false;}

$mysqli->close();
return $mybool;
}

function GetimagefromPost()
{
$mysqli = new mysqli( $GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
  if ($mysqli->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $image = "";
    if ( preg_match( '/gif|png|x-png|jpeg/', $_FILES['Photo']['type']) )
        {
      if ( $_FILES['Photo']['size'] > 50000 )
        {
        die('<p>Sorry file too large</p></body></html>');
        }
     if ( !($handle = fopen ($_FILES['Photo']['tmp_name'], "r")) )
        { die('Error opening temp file');}
     else if ( !($image = fread ($handle, filesize($_FILES['Photo']['tmp_name']))) )
        { die('Error reading temp file');}
     else
     {
         fclose ($handle);
         $image = mysql_real_escape_string($image);
      }
        }
    return $image;
}




function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}

?>
