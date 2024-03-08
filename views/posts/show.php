<?php
	include './views/includes/_header.php';
    $postDate = date_format(new DateTime($post->created_at), 'd/m/Y H:i');
?>
	<div class="container-fluid single-post-wrapper">
		<div class="row">
            <div class="col-md-12">
                <h1><?=$post->title?></h1>
            </div>
            <hr>
        </div>

        <div class="row icons">
            <div>
                <ion-icon name="calendar-outline"></ion-icon>
                <?=$postDate?>
            </div>
            <div>
                <ion-icon name="share-social-outline"></ion-icon>
            </div>
            <div>
                <ion-icon name="paper-plane-outline"></ion-icon>
            </div>
            <div>
                <ion-icon name="chatbubbles-outline"></ion-icon>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="single-post-img" style="background:url('<?=BASE_URL.$this->e($post->image)?>')"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p><?=htmlspecialchars_decode($post->content)?></p>
            </div>
        </div>
	</div>

<?php
	include './views/includes/_footer.php';
?>

<script type="text/javascript" src="<?=BASE_URL.'/assets/js/index.js'?>"></script>
<script type="text/javascript">
    var base_url = "<?=BASE_URL?>";
</script>
