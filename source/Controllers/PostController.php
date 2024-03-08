<?php

declare(strict_types=1);
namespace Source\Controllers;
use League\Plates\Engine;
use CoffeeCode\DataLayer\Connect;
use Source\Models\Post;
use Source\BUS\PostBUS;

class PostController
{
	private $view;

	public function __construct()
	{	
		$this->view = new Engine(__DIR__."/../../views", "php");
	}

	public function index()
	{
		echo $this->view->render("posts/index", [
			"title" => SITE . " | Breaking News - Posts"
		]);
	}

	public function indexAjax($data) 
	{
		$posts = PostBUS::getPosts($data);
		header('Content-Type: application/json; charset=utf-8');
    	echo json_encode($posts); 
	}

	public function show($data)
	{
		$post = (new Post())->find("id = :id", "id={$data['id']}")->fetch();
		echo $this->view->render("posts/show", [
			"title" => SITE . " | Breaking News - Posts",
			"post" => $post
		]);
	}

	public function store() 
	{
		PostBUS::storePost();
	}

	public function edit($data) 
	{
		PostBUS::editPost($data);
	}

	public function update($data) 
	{
		PostBUS::updatePost($data);
	}

	public function delete($data) 
	{
		PostBUS::deletePost($data);
	}
}
