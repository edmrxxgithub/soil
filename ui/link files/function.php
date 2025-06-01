<?php

function user_level($pdo,$id)
{

	$select = $pdo->prepare("SELECT * from tb_user_level where id = $id");
	$select->execute();
	$row=$select->fetch(PDO::FETCH_OBJ);

	return $row->name;
}

function alertmessage()
{
	if (isset($_SESSION['alertmessage'])) 
	{
		echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<h6>'.$_SESSION['alertmessage'].'</h6>
				 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
				 </button>
			 </div>';
		 unset($_SESSION['alertmessage']);
	}
}


?>