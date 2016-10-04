<?php
   session_start();
   include("databaseConnection.php");
?>

<!DOCTYPE HTML> 
 
<html>

	<head>

		<meta charset="utf-8" />      

		<link href="./css/style.php" rel="stylesheet" media="all" type="text/css">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

      <title>STI Messenger</title>
      
	</head>

	<body>  

		<h1>STI Messenger - Boîte de réception</h1>

		<p> 
			<?php
            // Check if user session exist
            if (isset($_SESSION['userId'])) {
				   echo "Welcome ";
				   echo $_SESSION['userName'];
				   echo " !</br>";
				}
				else {
				   echo "Sorry, you must log in to access this page.";
				}
			?>
		</p>
		
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="messages.php">
				Messages reçus
			  </a>
			</div>
			<div class="navbar-header">
			  <a class="navbar-brand" href="newMessage.php">
				Nouveaux messages
			  </a>
			</div>
			<div class="navbar-header">
			  <a class="navbar-brand" href="#">
				Changer le mot de passe
			  </a>
			</div>
			<?php
			if ($_SESSION['user_role'] == 1){
				echo '<div class="navbar-header">
			  <a class="navbar-brand" href="admin.php">
				Administration
			  </a>
			</div>';
			}
			
			
			?>
		  </div>
		</nav>
		
		<?php
			// take user messages
			   $sql = "SELECT * FROM messages WHERE message_receiver_id = $_SESSION['user_id']";
               global $file_db;
               $result =  $file_db->query($sql);
               $result->setFetchMode(PDO::FETCH_ASSOC);
               $result = $result->fetch();
		
		?>

		<table class="table table-striped">
			<tr>
				<td>Date</td>
				<td>Expéditeur</td>
				<td>Sujet</td>
				<td>Répondre</td>
				<td>Supprimer</td>
				<td>Ouvrir</td>
			</tr>
			
			<?php
				foreach($result as $row){ 
			?>
				<tr>
					<td><?php echo $row['message_time']; ?></td>
					<td><?php echo $row['message_sender']; ?></td>
					<td><?php echo $row['message_subject']; ?></td>
					<td><?php echo '<a href="answer.php?receiver="' . $row['message_sender_id'] . '> Répondre </a>'; ?></td>
					<td><?php echo '<a href="deleteMessage.php?id="' . $row['message_id'] . '> Supprimer </a>'; ?></td>
					<td><?php echo $row['']; ?></td>
					
				</tr>
				<tr>
					<button data-toggle="collapse" data-target="#message<?php echo $row['message_id'] ?>">Collapsible</button>

					<div id="#message<?php echo $row['message_id'] ?>" class="collapse">
						<td> <?php echo $row['message_message'] ?> </td>
					</div>
				</tr>
			<?php 
				}
			?>
		</table>
		
	</body>

</html>
