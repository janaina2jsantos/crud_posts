<?php
	include './views/includes/_header.php';
?>
	<div class="container-fluid home-wrapper">
		<div class="row cms-title">
			<div class="col-md-12">
				<h1>The City Times</h1>
			</div>
			<hr>
			<hr class="divider">
		</div>	

		<div class="row posts-wrapper">
			<?php if(count($posts)): ?>
				<?php foreach($posts as $post): ?>
					<div class="col-md-4 card">
						<a href="<?=BASE_URL.'/posts/'.$post->id.'/'.$post->title?>" class="image-link">
							<div class="card-img" style="background:url('<?=BASE_URL.$this->e($post->image)?>')"></div>
					  	</a>
					  	<div class="card-body">
					    	<a href="<?=BASE_URL.'/posts/'.$post->id.'/'.$post->title?>" class="post-link">
					    		<h5 class="card-title"><?=$post->title?></h5>
					    		<p class="card-text"><?=substr(strip_tags($post->content), 0, 250 ), '...' ?></p>
					    	</a>
					  	</div>
					</div>
				<?php endforeach ?>
			<?php else: ?>
				<p>No records found</p>
			<?php endif ?>
		</div>
	</div>

<?php
	include './views/includes/_footer.php';
?>

<script type="text/javascript" src="<?=BASE_URL.'/assets/js/index.js'?>"></script>
<script type="text/javascript">
    var base_url = "<?=BASE_URL?>";
</script>

