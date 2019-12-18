<!doctype html>
<html>
<style type="text/css">
	
body{text-align: center;}

</style>
<head>
    <meta charset="UTF-8">
    <title>TP BD</title>
</head>


<body>
    

    <h1>TP Base de données Alide Xiang et Chaker Memmadi</h1>
    


<a href="sqlQuery.php">SQL queries</a>
<a href="TableModification.php">SQL table modification</a>

<?php 

$servername = "localhost";
$username = "root";
$password = "";


//echo $_POST["Create_Database"];
//echo $_POST["Delete_Database"];
//echo $_POST["TableAttributes"];


///////////////////////////////////////////////////////////////////
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
if (isset($_POST["Create_Database"])) {
	# code...
	$sql = "CREATE DATABASE myDB";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully";
	} else {
	    echo "Error creating database: " . $conn->error;
	}
}

//delete database
if (isset($_POST["Delete_Database"])) {
	# code...
	$sql = "DROP DATABASE IF EXISTS myDB";
	if ($conn->query($sql) === TRUE) {
	    echo "Database deleted successfully";
	} else {
	    echo "Error deleting database: " . $conn->error;
	}
}


$conn->close();
///////////////////////////////////////////////////////////////////////





if( isset($_POST['Table_Name']) && isset($_POST['Table_Attributes']) ){

	// Create connection
	$conn = new mysqli($servername, $username, $password,"myDB");
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
	// sql to create table


	$sql = 'CREATE TABLE ' . $_POST["Table_Name"] . ' ( '
	 . $_POST["Table_Attributes"] .' )';
	

	if ($conn->query($sql) === TRUE) {
	    echo "Table  created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	$conn->close();

}







if (isset($_POST["Select_Table"]) ) {




}




//$conn = mysqli_connect("localhost", "root", "test", "phpsamples");

if (isset($_POST["Import_csv"]) ) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {


        	$Values='('. $column[0];
			$i=1;
			while(isset($column[$i])){

					if (is_string($column[$i])) {
						$Values .= ",". "'" . $column[$i] . "'";	
					}else{	
						$Values .= ",". $column[$i]; 
					}
					$i++; 
				}
			$Values = $Values . ')';


            $sqlInsert = "INSERT into ". $_POST["Select_Table"]." VALUES ". $Values ;

            $result = mysqli_query($conn, $sqlInsert);
            


            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}







 ?>


    <form method="post" action="index.php">
        <input type="submit" name='Create_Database' value="Create_Database"/>
    </form>
<br>

<br>


    <form method="post" action="index.php"> <br>

    <input type="text" placeholder="Table_Name" name="Table_Name"/>

<br>
<br>
	WRITE THE TABLE ATTRIBUTES LIKE THIS IN THIS TEXTAREA BELOW:<br>

    AttributeName TypeName PRIMARY KEY,<br>

    AttributeName TypeName NOT NULL<br>


    <textarea name="Table_Attributes" cols="45" rows="50" placeholder="AttributeName TypeName feature," style="height:110px; width: 550px; white-space: pre-line;"> 

    </textarea>

    <br>
    <br>
    <input type="submit" name="Create_Table" value="Create_Table"/>
    
    </form>



<h2>Insert Data into a table</h2>

<?php 
		if (isset($_POST["Select_Table"]) ) {

		echo  $_POST["Select_Table"] .' table selected';
}

 ?>	
		<form name="Select_TableForm" method="post" action="index.php">  
            Select Table:  
            <select Name="Select_Table">  
            <option value="">--- Select ---</option>



<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=myDB;charset=utf8', 'root', '');
	}
	catch(Exception $e)
	{
	        die('Erreur : '.$e->getMessage());
	}
	$sql = "SHOW TABLES";
	$statement = $bdd->prepare($sql);
	$statement->execute();
	$tables = $statement->fetchAll(PDO::FETCH_NUM);
	//Loop through our table names.
	foreach($tables as $table){
?>
            <option value="<?php echo $table[0]; ?>"> <?php echo $table[0]; ?>  </option>
            
<?php } ?>           
            </select>  
            <input type="submit" />  
        </form>  






<div style="display: flex; flex-direction: row; justify-content: space-around" >

	<div>
    <h3>Import csv file</h3>

    <form class="form-horizontal" action="" method="post" name="uploadCSV"
    enctype="multipart/form-data">
    <div class="input-row">
        <label class="col-md-4 control-label">Choose CSV File</label><br> <input
            type="file" name="file" id="file" accept=".csv">
            <br>
        <button type="submit" id="submit" name="Import_csv"
            class="btn-submit">Import</button>
        <br />

    </div>
    <div id="labelError"></div>

</form>
</div>

<div>
	
    <h3>Add a tuple </h3>

	<form name="InsertRowTable" method="post" action="index.php">  


<?php 


	if (isset($_POST["1"])) {

	try{
		$bdd = new PDO('mysql:host=localhost;dbname=myDB;charset=utf8', 'root', '');
	}
	catch(Exception $e){
	        die('Erreur : '.$e->getMessage());
	}

	//Create the row of table

	$Values='('. $_POST["1"];
	$i=2;
	while(isset($_POST[$i])){

		if (is_string($_POST[$i])) {
			$Values .= ",". "'" . $_POST[$i] . "'";	
		}else{	
			$Values .= ",". $_POST[$i]; 
		}
		$i++; 
	}
	$Values = $Values . ')';


	$sql = 'INSERT INTO ' . $_POST["Select_Table"] ." VALUES ". $Values  ;
	$result = $bdd->query($sql);
	print_r($result);

	}







		if (isset($_POST["Select_Table"]) ) {

		echo  '<br>' .'Table '.$_POST["Select_Table"];

	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=myDB;charset=utf8', 'root', '');
	}
	catch(Exception $e)
	{
	        die('Erreur : '.$e->getMessage());
	}
	$sql = 'SELECT * FROM ' . $_POST["Select_Table"] ;

	$result = $bdd->query($sql);
	//print_r($result);
	$colcount = $result->columnCount();
	//echo $colcount;


?>
<div style="display: flex; flex-direction: row; justify-content: space-around;">
<?php

	for ($i=1; $i<=$colcount;$i++){
?>
<input type="text" name="<?php echo $i;  ?>">
<?php	} 

echo "<input type='hidden' name='Select_Table' value=" . "'" . $_POST["Select_Table"] . "'" .">" ;
echo "<br>
<br>
</div>
<input type='submit' >";
} ?>	


</form>
	





</div>

</div>

<br>
<br>
<br>


<form method="post" action="index.php">
        <input type="submit" name="Delete_Database" value="Delete_Database"/>
    </form>


    


<br>
<br>


    <footer>
        <div style="text-align: center;"> Fait avec <span style="color: #e25555;">&#9829;</span> en France</div>
    </footer>
</body>











<!-- 

/* connect to the db */
$connection = mysql_connect('localhost','username','password');
mysql_select_db('my_db',$connection);

/* show tables */
$result = mysql_query('SHOW TABLES',$connection) or die('cannot show tables');
while($tableName = mysql_fetch_row($result)) {

	$table = $tableName[0];
	
	echo '<h3>',$table,'</h3>';
	$result2 = mysql_query('SHOW COLUMNS FROM '.$table) or die('cannot show columns from '.$table);
	if(mysql_num_rows($result2)) {
		echo '<table cellpadding="0" cellspacing="0" class="db-table">';
		echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default<th>Extra</th></tr>';
		while($row2 = mysql_fetch_row($result2)) {
			echo '<tr>';
			foreach($row2 as $key=>$value) {
				echo '<td>',$value,'</td>';
			}
			echo '</tr>';
		}
		echo '</table><br />';
	}
}

  -->
</html>