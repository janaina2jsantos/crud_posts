<?php
	include './views/includes/_header.php';

	if ((!isset($_SESSION['role']) || $_SESSION['role'] != 1)) { 
        header('Location: ' . BASE_URL.'/');  
        exit;      
    }
?>
	<div class="container-fluid dashboard-wrapper">
		<div class="row top-content">
            <div class="col-md-6 top-content-left">
                <span>
                    <ion-icon name="documents-outline"></ion-icon>
                    <h3>Posts</h3>
                </span>
            </div>
            <div class="col-md-6 top-content-right">
                <a href="#" class="btn btn-primary" id="btnCreatePost">
                    <i class="fas fa-plus"></i>
                    &nbsp;Add Post
                </a>
            </div>
        </div>
        <hr>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="published-tab" data-bs-toggle="tab" data-bs-target="#published" type="button" role="tab" aria-controls="published" aria-selected="true" onclick="getPosts('published');">Published</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draft" type="button" role="tab" aria-controls="draft" aria-selected="false" onclick="getPosts('draft');">Draft</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="trash-tab" data-bs-toggle="tab" data-bs-target="#trash" type="button" role="tab" aria-controls="trash" aria-selected="false" onclick="getPosts('trash');">Trash</button>
            </li>
        </ul>

        <div class="tab-pane fade show active" id="published" role="tabpanel" aria-labelledby="published-tab">
            <div class="card-body" id="cardBody">
                <h5 id="textResult" style="display:none;"></h5>
                <table class="table stripe" id="tableResult">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th></th>
                            <th>Thumb</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableResultBody">
                    </tbody>
                </table>
            </div>
        </div>

        <!-- modal create/edit post -->
        <div class="modal fade" role="dialog" aria-hidden="true" id="postFormModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="postTitle"></h2>
                        <button type="button" class="btn-close btn-hide" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="col-md-12" id="divAlert02"></div>
                    <div class="modal-body" id="modalBody">
                        <form id="postForm">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" />
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label">Content</label>
                                    <textarea name="content" rows="10" id="content"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option selected="" value="0" disabled="">Choose</option>
                                        <option value="1">Published</option>
                                        <option value="2">Draft</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/jpeg, image/jpg, image/png" id="image" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer" style="justify-content: flex-start;">
                        <button type="button" class="btn btn-primary btn-block btn-classic" id="btnSpinner" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Aguarde...
                        </button>
                        <button type="button" class="btn btn-primary" id="btnSavePost"></button>
                        <button type="button" class="btn btn-secondary btn-hide" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
	</div>

<?php
	include './views/includes/_footer.php';
?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="<?=BASE_URL.'/assets/js/posts/index.js'?>"></script>
<script type="text/javascript">
    var base_url = "<?=BASE_URL?>";
</script>
