<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?=$title?></title>
	<link rel="stylesheet" type="text/css" href="<?=BASE_URL.'/assets/css/bootstrap.min.css'?>" />
    <link rel="stylesheet" type="text/css" href="<?=BASE_URL.'/assets/css/custom.css?p=1'?>" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" />
    <!-- bootstrap -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
	<!-- datatable -->
    <link rel="stylesheet" type="text/css" href="<?=BASE_URL.'/assets/css/jquery.dataTables.min.css'?>" />
	<script type="text/javascript" src="<?=BASE_URL.'/assets/js/jquery.dataTables.min.js'?>"></script>
	<!-- ckeditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script type="text/javascript" src="<?=BASE_URL.'/assets/js/cdnjs.cloudflare.com_ajax_libs_jqueryui_1.12.1_jquery-ui.min.js'?>"></script>
</head>
<body>
	<?php
		$currentDate = date('l, F j, Y');
	?>
	<div class="container-fluid">
		<div class="row">
			<nav class="navbar navbar-light bg-light">
				<div class="col-md-8">
				  	<a class="navbar-brand" href="<?=BASE_URL?>">
				    	<img src="<?=BASE_URL.'/assets/img/logo.png'?>" alt="The City Times" />
				    	<span class="date-info">Welcome - <?=$currentDate?></span>
				  	</a>
			  	</div>
			  	<div class="col-md-4 navbar-buttons">
					<?php if (isset($_SESSION['role'])): ?>
				  		<li class="nav-item dropdown">
					        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
					          	Admin
					        </a>
					        <div class="dropdown-menu">
					          	<a href="<?=BASE_URL.'/posts'?>" class="dropdown-item">Posts</a>
					          	<a href="<?=BASE_URL.'/logout'?>" class="dropdown-item">Logout</a>
					        </div>
					     </li>
					<?php else: ?>
						<a href="#" class="navbar-brand" id="btnLogin">
				  			<span>
				  				<ion-icon name="person-outline" class="login"></ion-icon>
				  				&nbsp;Login
				  			</span>
						</a>
					<?php endif ?>
				</div>
			</nav>
		</div>

		<!-- modal login -->
        <div class="modal fade" role="dialog" aria-hidden="true" id="loginModal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="loginTitle">Log in to your account</h2>
                        <button type="button" class="btn-close btn-hide" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-md-12" id="divAlert"></div>
                    <div class="modal-body" id="modalBody">
                        <form id="loginForm">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label"></label>
                                    <input type="email" class="form-control" name="email" id="userEmail" placeholder="Email" />
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label"></label>
                                    <input type="password" class="form-control" name="password" id="userPassword" placeholder="Password" autocomplete="none" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer" style="justify-content: flex-start;">
                        <button type="button" class="btn btn-primary btn-block btn-classic" id="btnSpinner" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Aguarde...
                        </button>
                        <button type="button" class="btn btn-primary" id="btnLogin02" onclick="login();">Log In</button>
                    </div>
                </div>
            </div>
        </div>
	</div>
	