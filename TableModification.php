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
    


<a href="sqlQuery.php">SQL queries</a> <br>
<a href="index.php">SQL database creation</a>

<br>
<br>









<h2>Table Modification</h2>

<?php 
		if (isset($_POST["Select_Table"]) ) {

		echo  $_POST["Select_Table"] .' table selected';
}

 ?>	
		<form name="Select_TableForm" method="post" action="TableModification.php">  
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


<?php

if (isset($_POST["Select_Table"]) ) {

	echo "
	<table>
    <thead>
        <tr>
            <th>The table </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>The table body</td>
            <td>with two columns</td>
        </tr>"
        ;

	try{
		//$bdd = new PDO('mysql:host=localhost;dbname=myDB;charset=utf8', 'root', ''); 
		$bdd = new PDO('mysql:host=localhost;dbname=myDB;charset=utf8', 'root', '');
	}
	catch(Exception $e){
	        die('Erreur : '.$e->getMessage());
	}
	$sql = "SELECT * FROM ". $_POST["Select_Table"];
	echo $sql;
	//$reponse = $bdd->query($sql);

/*
	if ($result = $bdd -> query($sql)) {
  while ($column = $result -> fetch(PDO::FETCH_NUM)) {
  	echo $column[0] . " \n   ";
  	echo $column[3];
}

*/

if ($result = $bdd -> query($sql)) {
  	while($column = $result -> fetch(PDO::FETCH_NUM)) {
				echo '<tr>';
				foreach($column as $key=>$value) {
					//echo '<td>',$value,'</td>';
				echo '<td>',"<input type='text' value=$value>",'</td>';
				}
				echo '</tr>';
			}
		//	echo '</table><br />';
}    
  
	echo "
    </tbody>
</table>";


}
?>







    <footer>
        <div style="text-align: center;"> Fait avec <span style="color: #e25555;">&#9829;</span> en France</div>
    </footer>
</body>


</html>