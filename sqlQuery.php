<!doctype html>
<html>
<style type="text/css">
body {
    text-align: center;
}
</style>

<head>
    <meta charset="UTF-8">
    <title>TP BD</title>
</head>

<body>
    <h1>TP Base de données Alide Xiang et Chaker Memmadi</h1>
    <a href="index.php">SQL queries</a> <br>
    <a href="TableModification.php">SQL table modification</a>


    <br>
    <form method="post" action="sqlQuery.php">
        <br>
        <br>
        ENTER YOUR SQL QUERY:<br>
        <textarea name="SQL_Query" cols="45" rows="50" placeholder="AttributeName TypeName feature," style="height:110px; width: 550px; white-space: pre-line;"> </textarea>
        <br>
        <input type="submit" />
    </form>

    <br>
        <br>




    <?php


    if (isset($_POST["SQL_Query"])) {

        echo "SQL ANSWER: <br><br>";

		try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=myDB;charset=utf8', 'root', '');
			}
			catch(Exception $e)
			{
			        die('Erreur : '.$e->getMessage());
			}
			$sql = $_POST["SQL_Query"];
			$statement = $bdd->prepare($sql);
			$statement->execute();
			$tables = $statement->fetchAll(PDO::FETCH_NUM);
			print_r($statement);

        }

		?>

    <br>
    <br>
    <br>

    <footer>
        <div style="text-align: center;"> Fait avec <span style="color: #e25555;">&#9829;</span> en France</div>
    </footer>
</body>

</html>