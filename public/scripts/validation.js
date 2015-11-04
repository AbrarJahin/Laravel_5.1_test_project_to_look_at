$(".validateWebinarDomain").click(function() {

    var custom_domain = $("#custom_domain").val();
    if (custom_domain == '') {
        alert("Please Enter Custom Domain");
        return false;
    }

    $("#domainValidationModal").modal('show');
    var csrf_token = $("input[name='_token']").val();
    var data = {'_token' : csrf_token, 'custom_domain': custom_domain};
    $.ajax({
        type: 'Post',
        url: baseUrl + 'members/validate-webinar-domain',
        data: data,
        dataType: 'json',
        success: function(response) {
            var flgCount = 0;
            $("#google_dns > span").html('');
            $("#level3_dns > span").html('');
            $("#open_dns > span").html('');

            if (response.google_dns_check) {
                flgCount++;
                $("#google_dns").addClass("text-success");
                $("#google_dns > span").addClass('glyphicon glyphicon-ok');
            } else {
                $("#google_dns").addClass("text-danger");
                $("#google_dns > span").addClass('glyphicon glyphicon-remove');
            }

            if (response.level3_dns_check) {
                flgCount++;
                $("#level3_dns").addClass("text-success");
                $("#level3_dns > span").addClass('glyphicon glyphicon-ok');
            } else {
                $("#level3_dns").addClass("text-danger");
                $("#level3_dns > span").addClass('glyphicon glyphicon-remove');
            }

            if (response.open_dns_check) {
                flgCount++;
                $("#open_dns").addClass("text-success");
                $("#open_dns > span").addClass('glyphicon glyphicon-ok');
            } else {
                $("#open_dns").addClass("text-danger");
                $("#open_dns > span").addClass('glyphicon glyphicon-remove');
            }

            if (flgCount == 2 || flgCount == 3) {
                $("#domainValidationModal").modal('hide');
                $("#frmSetting").submit();
            }
        },
        error: function() {
            alert("Some Error Occured while processing your request.");
        }
    });
});

$(".closeValidateDomainModal,.close").click(function(ev) {
    ev.preventDefault();
    location.reload();
});

$(".testSmtp").click(function() {
    var isValid = validateSmtpForm();
    if (isValid) {
        var message = $("#message").val();
        if(message == ""){
            alert("Please enter Message");
            $("#message").focus();
            return false;
        }
        $("#smtp_test_button").prop("disabled", true);
        $("#smtp_test_button").html("Please Wait...");
        var csrf_token = $("input[name='_token']").val();
        var host = $("#host").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var port = $("#port").val();
        var protocol = $("#protocol").val();
        var from_email = $("#from_email").val();
        var from_name = $("#from_name").val();
        var reply_email = $("#reply_email").val();
        var data = {
            '_token' : csrf_token,
            'message': message,
            'host': host,
            'username': username,
            'password': password,
            'port' : port,
            'protocol' : protocol,
            'from_email': from_email,
            'from_name': from_name,
            'reply_email': reply_email
        };

        $.ajax({
            type: 'Post',
            url: baseUrl + 'smtp/validate-smtp',
            data: data,
            dataType: 'json',
            success: function(response) {
                $("#smtp_test_button").prop("disabled", false);
                $("#smtp_test_button").html("Test SMTP");
        
                if(response.success){
                    alert("Mail Sent Successfully");
                    $("#smtp_submit_button").prop("disabled", false);
                } else {
                    alert("Mail Not sent, Please check SMTP Configuration");
                    $("#smtp_submit_button").prop("disabled", true);
                }
            },
            error: function() {
                alert("Some Error Occured while processing your request.");
                $("#smtp_test_button").prop("disabled", false);
                $("#smtp_test_button").html("Test SMTP");
            }
        });
    }
});

function validateSmtpForm() {
    var isValid = true;
    var ids = [
        "name",
        "host",
        "username",
        "password",
        "port",
        "protocol",
        "from_email",
        "from_name",
        "reply_email"
    ];
    var messages = [
        "Please enter Name", 
        "Please Enter Host", 
        "Please Enter Username", 
        "Please Enter Password", 
        "Please Enter Port", 
        "Please Select Protocol",
        "Please Enter From Email",
        "Please Enter From Name",
        "Please Enter Reply To Email"
    ];
    $.each(ids, function(key, value){
        if($("#"+value).val() == ''){
            alert(messages[key]);
            $("#"+value).focus();
            isValid = false;
            return isValid;
        }
    });
    return isValid;
}

$("input[type='checkbox'][name='smtp_method']").on("change", function() {
    $("input[type='checkbox'][name='smtp_method']").not(this).prop("checked", false);  
});

function validateWebinarEmailForm(){
    var subject = $("#subject").val();
    var content = tinyMCE.get('content').getContent();
    var count_smtp_checkbox = $("input[type='checkbox'][name='smtp_method[]']:checked").length;
    if(subject == ''){
        alert("Please enter the Subject");
        $("#subject").focus();
        return false;
    } else if(content == ''){
        alert("Please enter the Content");
        return false;
    } else if(count_smtp_checkbox  == 0){
        alert("Please Select SMTP Method");
        return false;
    } else if(count_smtp_checkbox > 1){
        alert("You can only select only one SMTP Option");
        return false;
    } else {
        return true;
    }
    
}

function validateEmailNotificationForm(){
    var subject = $("#subject").val();
    var content = tinyMCE.get('content').getContent();
    var count_smtp_checkbox = $("input[type='checkbox'][name='smtp_method']:checked").length;
    var count_send_type_radio = $("input[type='radio'][name='send_type']:checked").length;
    var send_type = $("input[type='radio'][name='send_type']:checked").val();
    if(subject == ''){
        alert('Please Enter Subject');
        $("#subject").focus();
        return false;
    } else if(content == ''){
        alert('Please Enter Content');
        return false;
    } else if(count_smtp_checkbox  == 0){
        alert('Please Select SMTP Method');
        return false;
    } else if(count_smtp_checkbox > 1){
        alert('You can select only one SMTP Option');
        return false;
    } else if(count_send_type_radio == 0){
        alert('Please select the option when to send Email Notification');
        return false;
    } else if(send_type == "minutes_before"){
        if($("#minutes_before_webinar").val() == 0){
            alert("Please Enter the Minutes Before Webinar");
            $("#minutes_before_webinar").focus();
            return false;
        }
    } else {
        return true;
    }
}