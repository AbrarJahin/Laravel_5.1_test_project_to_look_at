$("#webinarForm").on('change','input[type=radio][name=streaming_server_id]',function () {

    var radio = $(this);
    if(radio.val() == 'custom'){
        $('#share_container').show();
    } else {
        $('#share_container').hide();

    }

});
