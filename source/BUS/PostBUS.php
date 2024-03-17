<?php

declare(strict_types=1);
namespace Source\BUS;

use CoffeeCode\DataLayer\Connect;
use Source\Models\Post;

class PostBUS 
{
	public static function getPosts($data=null): array
	{
		try {
			$conn = Connect::getInstance();

			if (!$conn) {
                // throw new \Exception("Error connecting to the database.");
                header("Location: ./500.php");
            }

			if (isset($data['status'])) {
				if ($data['status'] == 'published') {
					$stmt = $conn->prepare('SELECT * FROM posts WHERE status = 1 ORDER BY id DESC');
				}
				elseif ($data['status'] == 'draft') {
					$stmt = $conn->prepare('SELECT * FROM posts WHERE status = 2 ORDER BY id DESC');
				}
				else {
					$stmt = $conn->prepare('SELECT * FROM posts WHERE status = 3 ORDER BY id DESC');
				}
			}
			else {
				$stmt = $conn->prepare('SELECT * FROM posts WHERE status = 1 AND deleted_at IS NULL ORDER BY id DESC');
			}

	        $stmt->execute();
		    $results = $stmt->fetchAll();
		    return $results;
		 } 
		catch(\PDOException $e) {
            throw new \Exception("Error connecting to the database: " . $e->getMessage());
        }
	}

	public static function storePost(): void
	{
		$conn = Connect::getInstance();
    	date_default_timezone_set('America/Sao_Paulo');
		$currentDate = date('Y-m-d H:i:s');

		if (empty($_POST['title'])) {
			die(json_encode(array('error' => 'The field "Title" is required.')));
		}
		if (empty($_POST['content'])) {
			die(json_encode(array('error' => 'The field "Content" is required.')));
		}
		if (empty($_POST['status'])) {
			die(json_encode(array('error' => 'The field "Status" is required.')));
		}
		if ($_FILES['image']['type'] == "") {
			die(json_encode(array('error' => 'The field "Image" is required.')));
		}

		// upload
		if ((isset($_FILES['image'])) && ($_FILES['image']['type'] != "")) {
			if(!is_dir("uploads/posts/")) {
				mkdir("uploads/posts/");
			}

			$file = $_FILES["image"];
			// checks if image is valid
			if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png') {
				$uploaded = "uploads/posts/". $_FILES["image"]["name"]; 
				move_uploaded_file($_FILES['image']['tmp_name'], $uploaded);
			}
		}

		$uploaded = isset($uploaded) ? "/".$uploaded : null;

		try {
			$stmt = $conn->prepare('INSERT INTO posts (title, content, status, image, created_at, updated_at) VALUES (:title, :content, :status, :image, :created_at, :updated_at)');
			$stmt->bindParam(':title', $_POST['title']);
			$stmt->bindParam(':content', $_POST['content']);
			$stmt->bindParam(':status', $_POST['status']);
			$stmt->bindParam(':image', $uploaded);
			$stmt->bindParam(':created_at', $currentDate);
			$stmt->bindParam(':updated_at', $currentDate);
			$stmt->execute();
			echo json_encode(true);
		}catch(\PDOException $e) {
		  	throw new \Exception("Error connecting to the database: " . $e->getMessage());
		}
	}

	public static function editPost($data): void
	{
		$conn = Connect::getInstance();
		$stmt = $conn->prepare('SELECT id, title, content, status FROM posts AS ps
			WHERE ps.id = :id');
		$stmt->bindParam(':id', $data['id']);
        $stmt->execute();
	    $post = $stmt->fetch();
		header('Content-Type: application/json; charset=utf-8');
    	echo json_encode($post);
	}

	public static function updatePost($data): void 
	{
		$conn = Connect::getInstance();
		$post = (new Post())->find("id = :id", "id={$data['id']}")->fetch();

		if (empty($_POST['title'])) {
			die(json_encode(array('error' => 'The field "Title" is required.')));
		}
		if (empty($_POST['content'])) {
			die(json_encode(array('error' => 'The field "Content" is required.')));
		}

		// upload
		if ((isset($_FILES['image'])) && ($_FILES['image']['type'] != "")) {
			if(!is_dir("uploads/posts/")) {
				mkdir("uploads/posts/");
			}

			$file = $_FILES["image"];
			// checks if image is valid
			if ($file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg' || $file['type'] == 'image/png') {
				$uploaded = "uploads/posts/". $_FILES["image"]["name"]; 
				move_uploaded_file($_FILES['image']['tmp_name'], $uploaded);
			}
		}

		$uploaded = isset($uploaded) ? "/".$uploaded : $post->image;
		$status = isset($_POST['status']) ? $_POST['status'] : $post->status;
	
		try {
			$stmt = $conn->prepare('UPDATE posts SET title=:title, content=:content, status=:status, image=:image, deleted_at=:deleted_at WHERE id=:id');
			$stmt->execute(array(
			    ':id' => $post->data()->id,
			    ':title' => $_POST['title'],
			    ':content' => $_POST['content'],
			    ':status' => $status,
			    ':image' => $uploaded,
			    ':deleted_at' => null
			));
			echo json_encode(true);
		}catch(\PDOException $e) {
		  	throw new \Exception("Error connecting to the database: " . $e->getMessage());
		}
	}

	public static function deletePost($data): void  
	{
		$conn = Connect::getInstance();
		$currentDate = date('Y-m-d H:i:s', time());		

		if ($data['status'] != 3) {
			try {
				$stmt = $conn->prepare('UPDATE posts SET status=:status, deleted_at=:deleted_at WHERE id=:id');
				$stmt->execute(array(
				    ':id' => $data['id'],
			    	':status' => 3,
				    ':deleted_at' => $currentDate
				));
				echo json_encode(true);
			}catch(\PDOException $e) {
			  	throw new \Exception("Error connecting to the database: " . $e->getMessage());
			}
		}
		else {
			try {
				$stmt = $conn->prepare('DELETE FROM posts WHERE id=:id'); 
				$stmt->bindParam(':id', $data['id']);
				$stmt->execute();
				echo json_encode(true);
			}catch(\PDOException $e) {
			  	throw new \Exception("Error connecting to the database: " . $e->getMessage());
			}
		}
	}
}

