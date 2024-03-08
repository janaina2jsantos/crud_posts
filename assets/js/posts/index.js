var editor;

$('#btnCreatePost').on('click', function() {
    $('#postFormModal').modal('show'); 
    $('#postTitle').text('Add Post');
    $('#btnSavePost').text('Add').attr('onClick', 'storePost();');
});

$('.btn-hide').on('click', function() {
    $('#postFormModal').modal('hide');
    cleanModal(true);
});

function getPosts(status) {
    var url;

    if(status == 'published') {
        url = base_url + "/posts/ajax/published";
    }
    else if(status == 'draft') {
        url = base_url + "/posts/ajax/draft";
    }
    else  {
        url = base_url + "/posts/ajax/archived";
    }

    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        dataType: 'json',
        success: function(data) {
            $('#tableResult').show();
            $('#textResult').hide();
            setUpTable(data);
        },
        error: function(error) {
            $('#tableResult_wrapper').css('display', 'none');
            $('#tableResult').hide();
            $('#textResult').show();
            $('#textResult').html('No records found.');
            return;
        }
    });             
}

function setUpTable(data) {
    var table;
    var result = [];
    var status = '';

    if (data.length > 0) {
        result = data.map((e,i) => {
            var content = e.content.substring(0, 100) + '...';

            if (e.image != null) {
                var image = '<img src="'+base_url+e.image+'" alt="" class="thumbnail "/>';
            }

            if (e.status == '1') {
                status = '<span style="color:#13aba4; font-weight:bold;">\
                            <i class="fa fa-circle" aria-hidden="true" style="font-size: 8px;"></i>&nbsp;\
                            Published\
                        </span>';
            }
            else if (e.status == '2') {
                status = '<span style="color:#b8a852; font-weight:bold;">\
                            <i class="fa fa-circle" aria-hidden="true" style="font-size: 8px;"></i>&nbsp;\
                            Draft\
                        </span>';
            }
            else {
                status = '<span style="color:#f64e60; font-weight:bold;">\
                            <i class="fa fa-circle" aria-hidden="true" style="font-size: 8px;"></i>&nbsp;\
                            Archived\
                        </span>';
            }
            return [e.id, e.title, content, status, e.status, image];
        });
       
        $('#tableResult').DataTable().destroy();
        table = $('#tableResult').DataTable({
            data: result,
            "columnDefs": 
            [
                {
                    "target": 0,
                    "visible": false
                },
                {
                    "target": 1,
                    "width": "25%"
                },
                {
                    "target": 2,
                    "width": "35%"
                },
                {
                    "target": 3,
                    "width": "15%"
                },
                {
                    "target": 4,
                    "visible": false
                },
                {
                    "width": "10%",
                    "targets":6, render:function(data, type, row, meta) {  
                    return `<a href="#" class="btn btn-sm btn-primary" onclick="editPost(`+ row[0] +`);" title="Edit Post"><i class="fas fa-pencil-alt"></i></a>\
                        <a href="#" class="btn btn-sm btn-danger" onclick="deletePost('`+row[0]+`', '`+row[4]+`');" title="Delete Post"><i class="fas fa-trash"></i></a>`
                    } 
                },
            ],
            "info": false,
            "paging": true,
            "responsive": true,
            "searching": false,
            "bLengthChange": false,
            "order": [[0, 'desc']],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            },
            "pageLength": 5,
        }).draw();
    }
    else {
        $('#tableResult_wrapper').css('display', 'none');
        $('#tableResult').hide();
        $('#textResult').show();
        $('#textResult').html('No records found.');
    }
}

function storePost() {
    var url = base_url + "/posts/ajax/store";
    var form = $("#postForm").closest("form");
    var formData = new FormData(form[0]);
    formData.append('content', editor.getData());
    formData.append('image', $('#image').val());
    cleanModal();
    
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            if (response.error) {
                if (response.error.includes('Title')) {
                    $('#title').addClass('invalid');
                }
                else if(response.error.includes('Content')) {
                    $('.ck-editor').addClass('invalid');
                }
                else if(response.error.includes('Status')) {
                    $('#status').addClass('invalid');
                }
                else {
                    $('#image').addClass('invalid');
                }

                $('#divAlert02').css('display', 'flex')
                    .html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;&nbsp;'+response.error+'</div>');
                return;
            }
            Swal.fire({
                title: "Success!",
                text: "Post created successfuly.",
                icon: "success"
            }).then(function() {
                $('#postFormModal').modal('hide');
                cleanModal(true);
                getPosts('published');
            });
        },
        error: function(error) {
            $('#divAlert02').css('display', 'flex')
                .html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;&nbsp;'+error.responseJSON['error']+'</div>');
            return;
        }
    }); 
}

function editPost(id) {
    var url = base_url + "/posts/ajax/edit/" + id;
    $.ajax({
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: url,
        dataType: 'json',
        success: function(data) {
            $('#postFormModal').modal('show'); 
            $('#postTitle').text('Edit Post'); 
            $('#title').val(data.title); 
            editor.setData(data.content);

            if (data.status != 3) {
                $('#status').val(data.status); 
            }
            else {
                $('#status').val(0); 
            }

            $('#btnSavePost').text('Apply Changes').attr('onClick', 'updatePost('+id+')');
        },
        error: function(error) {
            return;
        }
    });  
}

function updatePost(id) {
    var url = base_url + "/posts/ajax/edit/" + id;
    var form = $("#postForm").closest("form");
    var formData = new FormData(form[0]);
    formData.append('content', editor.getData());
    formData.append('image', $('#image').val());

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            if (response.error) {
                if (response.error.includes('Title')) {
                    $('#title').addClass('invalid');
                }
                else if(response.error.includes('Content')) {
                    $('.ck-editor').addClass('invalid');
                }

                $('#divAlert02').css('display', 'flex')
                .html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;&nbsp;'+response.error+'</div>');
                return;
            }
            Swal.fire({
                title: "Success!",
                text: "Post updated successfuly.",
                icon: "success"
            }).then(function() {
                $('#postFormModal').modal('hide');
                location.reload(); 
            });
        },
        error: function(error) {
            return;
        }
    });
}

function deletePost(id, status) {
    var url = base_url + "/posts/ajax/delete/" + id + "/" + status;
    if (status == 3) {
        Swal.fire({
            title: 'Are you sure you want to delete this post?',
            text: 'This action cannot be undone!',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            customClass: "show-order",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: "Success!",
                            text: "Post deleted successfuly.",
                            icon: "success"
                        }).then(function() {
                           location.reload(); 
                       });
                    },
                    error: function(error) {
                        return;
                    }
                });
            }
        });
    }
    else {
        $.ajax({
            type: "DELETE",
            url: url,
            dataType: 'json',
            success: function(response) {
                Swal.fire({
                    title: "Success!",
                    text: "Post moved to trash.",
                    icon: "success"
                }).then(function() {
                   location.reload(); 
               });
            },
            error: function(error) {
                return;
            }
        });
    }
}

function cleanModal(reset=false) {
    if (reset) {
        $('#postFormModal').find('form').trigger('reset'); 
        editor.setData('');
        $('#divAlert02').css('display', 'none');
    } 
    $('#title').removeClass('invalid');
    $('#content').removeClass('invalid');
    $('#status').removeClass('invalid');
    $('#image').removeClass('invalid');
}

$(document).ready(function() {
    $.noConflict();
    getPosts('published');
    ClassicEditor
        .create( document.querySelector('#content'))
        .then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });
});