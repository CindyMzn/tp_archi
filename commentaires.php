<!doctype html> 
<html>
	<head> 
		<meta charset="utf-8">
	</head> 
	<body>
		<form method="POST">
			<input type="text" name="nom" placeholder="Nom"><br>
			<textarea name="commentaire" placeholder="Commentaire"></textarea><br>
			<input type="submit" value="Envoyer" name="envoyer">
		</form>
		<?php
			$lien=mysqli_connect("localhost","root","root","tp");
			if(isset($_POST['envoyer']))
			{
				$nom=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['nom'])));
				$commentaire=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['commentaire'])));
				$req="INSERT INTO commentaires VALUES (NULL,'$nom','$commentaire')";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL:$req<br>".mysqli_error($lien);
				}
			}
			
			if(!isset($_GET['page']))
			{
				$page=1;
			}
			else
			{
				$page=$_GET['page'];
			}
			$commparpage=5;
			$premiercomm=$commparpage*($page-1);
			$req="SELECT * FROM commentaires ORDER BY id LIMIT $premiercomm,$commparpage";/* LIMIT dit ou je commence et combien j'en prends*/
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				while($tableau=mysqli_fetch_array($res))
				{
					echo "<h2>".$tableau['nom']."</h2>";
					echo "<p>".$tableau['commentaire']."</p>";
				}
			}
			
			$req="SELECT * FROM commentaires";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				$nbcomm=mysqli_num_rows($res); // Retourne le nombre de lignes dans un r�sultat. 
				$nbpages=ceil($nbcomm/$commparpage); /*Ceil arrondit a l'entier sup�rieur*/
				echo "<br> Pages : ";
				echo "<a href='commentaires.php?page=1'> D�but </a>";
				echo "<a href='commentaires.php?page=".($page-1)."'> Pr�c�dente </a>";
				for($i=($page-2);$i<=($page+2);$i++)
				{
					echo "<a href='commentaires.php?page=$i'> $i </a>";
				}
			}
			mysqli_close($lien);
		?>	
		<a href='commentaires.php?page=".($page+1)."'> Suivante </a>";
		<a href='commentaires.php?page=$nbpages'> Fin </a>";
	</body>
</html>