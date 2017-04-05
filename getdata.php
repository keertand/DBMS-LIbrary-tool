<?php 
ini_set('max_execution_time', 3500);
//include "db.php";
/*
$con = mysqli_connect("localhost","root","Qwerty1!","library");

							if (mysqli_connect_errno()) {
							  echo "Failed to connect to MySQL: " . mysqli_connect_error();
							  exit();
							}
*/
include "db.php";
							
							{
								echo "Db connection Success!";
							
							$query = "TRUNCATE table Book";
							$results = mysqli_query($con,$query);
							
							$query = "TRUNCATE table Book_Authors";
							$results = mysqli_query($con,$query);
							
							
							$query = "TRUNCATE table authors";
							$results = mysqli_query($con,$query);
							
							
							

$myfile = fopen("books.csv","r");

$count = 0;

while(!feof($myfile)) {
	
	
  $temp = fgets($myfile);
  
  if($count>0)
  {
	  
	
	  
	echo '<br>{ Entry no: ' .$count. "} ";  
    $split_sentence = explode('	',$temp);
 
	$ISBN = $split_sentence[0];
	$title = $split_sentence[2];
	
	//foreach author enter author into author table, and get their author id, if already exists, then get their author id
	//$authors = getauthors($split_sentence[3]);

	$title = htmlspecialchars($title, ENT_QUOTES);
	$ISBN = htmlspecialchars($ISBN, ENT_QUOTES);
	
	$query = "insert into Book(Isbn, title) values ('$ISBN','$title')";
	$results = mysqli_query($con,$query);
	
	
	$authors = $split_sentence[3];
	
	$cover = $split_sentence[4];
	$publisher = $split_sentence[5];
	$pages = $split_sentence[6];

	$authors = str_replace(';', ',', $authors);
	$authors = str_replace("'", "", $authors);
	
	$author_array = explode(',',$authors);
	
	foreach ($author_array as $i)
	{
	
	$count2 = 0;
	$i = htmlspecialchars($i, ENT_QUOTES);
	echo $i;
	//check with author table if author exists.
	$query = "select 1 from Authors where Name = '$i'";
	$results = mysqli_query($con,$query);
	echo $query;
	
	while($row = mysqli_fetch_array($results))
	{
		$count2++;
	}
	
		if($count2>0) //if author exists
		{
		}
		else
		{
			//create an author id, update in author table in db.
			
			$query = "insert into Authors(Name) values('$i')";
			
			$results = mysqli_query($con,$query);
		}
		
		
		echo "<br>";
		$query = "select Author_id from Authors where Name = '$i'";
		$results = mysqli_query($con,$query);
		
		while($row = mysqli_fetch_array($results))
		{
			$id = $row['Author_id'];
		}
				
		$query = "insert into Book_Authors(Author_id, Isbn) values ('$id','$ISBN')";
		$results = mysqli_query($con,$query);
	}
	
  }

 $count++;
 }
  
  
  
fclose($myfile);

}
					

?>