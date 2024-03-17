<?php

declare(strict_types=1);
namespace Source\Controllers;

use League\Plates\Engine;
use CoffeeCode\DataLayer\Connect;
use Source\BUS\PostBUS;

class WebController
{
	private $view;

	public function __construct()
	{	
		$this->view = new Engine(__DIR__."/../../views", "php");
	}

	public function index()
	{	
		$posts = PostBUS::getPosts();
		echo $this->view->render("index", [
			"title" => SITE . " | Breaking News",
			"posts" => $posts
		]);
	}

	public function error($data)
	{
		echo "<h1>{$data['code']} Error</h1>";
	}
}
