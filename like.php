<?php 

	require'config/config.php';
		include("includes/classes/User.php");
		include("includes/classes/Post.php");
		//this will prevent not logged in user to log in
		if (isset($_SESSION['username'])) {
			$userLoggedIn = $_SESSION['username'];
			$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
			$user = mysqli_fetch_array($user_details_query);
		} else {
			header("Location: register.php");
		}

 ?>

<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<style type="text/css"> /*infile css for the font of the comment section*/
		*{
			font-family: Arial, Helvetica, Sans-serif;
		}

		body{
			background-color: #fff;
		}

		form{
		position: absolute;
		top: 0;
		}
	</style>

	<?php //bringing this to the top solves the problem of cannot modify header information error
	

		//get id of post
		if(isset($_GET['post_id'])){//if the element in the above script it sent to this page as a get variable
			$post_id = $_GET['post_id'];
		}



		$get_likes= mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");	
		$row = mysqli_fetch_array($get_likes);
		$total_likes = $row['likes'];
		$user_liked =$row['added_by'];
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username ='$user_liked'");
		$row = mysqli_fetch_array($user_details_query);
		$total_user_likes = $row['num_likes'];
	

		//like button - code that fire if the button is liked
		if (isset($_POST['like_button'])) {
			$total_likes++;
			//then uppdate the liked table
			$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id = '$post_id'");
			//also update the user likes in the users table
			$total_user_likes++;
			$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username = '$user_liked'");
			//insert the users name into the lkes table aswell to check if the have liked a post
			$insert_user = mysqli_query($con, "INSERT INTO likes VALUES(NULL, '$userLoggedIn', '$post_id')");
		
			//insert notification
		}
			//unlike button
		if (isset($_POST['unlike_button'])) {
			$total_likes--;
			//then uppdate the liked table
			$query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id = '$post_id'");
			//also update the user likes in the users table
			$total_user_likes--;
			$user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username = '$user_liked'");
			//insert the users name into the lkes table aswell to check if the have liked a post
			$insert_user = mysqli_query($con, "DELETE FROM likes WHERE username = '$userLoggedIn' AND post_id='$post_id'");
			}
			//insert notification

		

		//check for previous likes
		$check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id = '$post_id'");
		$num_rows = mysqli_num_rows($check_query);
		if ($num_rows > 0) {
			echo '<form action = "like.php?post_id=' . $post_id . '" method="POST">
			<input type ="submit" class="comment_like" name="unlike_button" value="unlike"
			<div class="like_value">
				'. $total_likes . ' Likes
			</div>
		</form>';
		}
		else{
			echo '<form action = "like.php?post_id=' . $post_id . '" method="POST">
			<input type ="submit" class="comment_like" name="like_button" value="like"
			<div class="like_value">
				'. $total_likes . ' Likes
			</div>
		</form>
		';
		}
	?>

</body>
</html>