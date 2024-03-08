$('#btnLogin').on('click', function() {
    $('#loginModal').modal('show'); 
});

$('.btn-hide').on('click', function() {
    $('#loginModal').modal('hide');
    $('#loginModal').find('form').trigger('reset'); 
    $('#divAlert').css('display', 'none');
    $('#userEmail').removeClass('invalid');
    $('#userPassword').removeClass('invalid');
});

function login() {
    var url = base_url + "/ajax/login";
    var form = $("#loginForm").closest("form");
    var formData = new FormData(form[0]);
    
    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            location.href = response.result;
        },
        error: function(error) {
            if (error.responseJSON['error'].includes('username')) {
                $('#userEmail').addClass('invalid');
                $('#userPassword').addClass('invalid');
            }
            else {
                $('#userEmail').removeClass('invalid');
                $('#userPassword').removeClass('invalid');
            }  

            $('#divAlert').css('display', 'flex')
            	.html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp;&nbsp;'+error.responseJSON['error']+'</div>');
            return;
        }
    }); 
}