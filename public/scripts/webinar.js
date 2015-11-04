$(".optinForm").click(function() {
    var webinar_id = $("#webinar_id").val();
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var email = $("#email").val();
    var csrf_token = $("input[name='_token']").val();
    
    if (first_name == '') {
        alert("Please Enter First Name");
        $("#first_name").focus();
        return false;
    }

    if (last_name == '') {
        alert("Please Enter Last Name");
        $("#last_name").focus();
        return false;
    }

    if (email == '') {
        alert("Please Enter Email");
        $("#email").focus();
        return false;
    }
    
    $(".optinForm").prop("disabled", true);
    var data = {'_token' : csrf_token, 'webinar_id': webinar_id, 'first_name': first_name, 'last_name': last_name, 'email': email};
    $.ajax({
        type: 'Post',
        url: baseUrl + 'webinar/add-lead',
        data: data,
        dataType: 'json',
        success: function(response) {
            if(response.success){
                $(".error_message").html('');
                $(".error_message").hide();
                $("#first_name").val('');
                $("#last_name").val('');
                $("#email").val('');
                alert("Thank you For Registering on Webinar");
            } else {
                // If Validation Fails Display Error Message
                var errors = response.errors;
                var err_msg_str = '';
                $.each(errors, function(key, value) {
                    err_msg_str += '<p>' + value + '</p>';
                });
                if(err_msg_str != ''){        
                    $(".error_message").html(err_msg_str);
                    $(".error_message").show();
                }
            }
            $(".optinForm").prop("disabled", false);
        },
        error: function() {
            alert("Some Error Occured while processing your request.");
            $(".optinForm").prop("disabled", false);
        }
    });
});