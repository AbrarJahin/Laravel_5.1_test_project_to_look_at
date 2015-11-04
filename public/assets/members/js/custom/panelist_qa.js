var baseURL,token,qa_id_clicked;

$(function()
{
    $( "#qa_answer_area" ).hide();
    baseURL = $('meta[name=base_url]').attr("content")+'/';
    token = $('meta[name=csrf_token]').attr("content");

    $("li.question").on("click", function(e)
    {
        alert("The paragraph was clicked.");
    });

    $("li.question").click(function(e)
    {
        e.preventDefault();
        //alert(baseURL+token+$(this).closest("li").attr('id'));
        qa_id_clicked=$(this).closest("li").attr('id');
        $.ajax(
        {
            headers: { 'X-CSRF-TOKEN': token},
            url: baseURL+"post_panelist_update_question",
            success: function(result)
            {
                $( "#qa_answer_area" ).show("easing");
                $.each(result, function(index, element)
                {
                    //console.log(element);
                    $.each(element,function(key,value)
                    {
                        //console.log(key+" - "+value);
                        if(key.localeCompare('answer')==0)
                        {
                            $("#question_answer_new").val(value);
                        }
                        else if(key.localeCompare('name')==0)
                        {
                            $("#name_answer_giving").html(value);
                        }
                        else if(key.localeCompare('question')==0)
                        {
                            $("#question_asked_answer_giving").html(value);
                        }
                        else if(key.localeCompare('question_ask_before')==0)
                        {
                            $("#time_before_answer_giving").html(value+" Before");
                        }
                    });
                });
            },
            method: "POST",
            data:
            {
                _token  :         token,
                id      : $(this).closest("li").attr('id')
            }/*,
            statusCode: {
                            407: function()
                            {
                                $.ajaxSetup(
                                                {
                                                    dataType: "jsonp"
                                                });
                                // Now all AJAX requests use JSONP, retry.
                                original();
                            }
                        },*/
        });

    });

    $("li.question").mouseover(function(e)
    {
        e.preventDefault();
        console.log( $(this).closest("li").attr('id') );
        //$(this).closest("li").toggleClass('selected');
        $(this).closest("li").addClass('selected');
    });

    $("li.question").mouseout(function(event)
    {
        $(this).closest("li").removeClass('selected');
        //console.log( $(this).closest("li").attr('id') );
        //$(this).closest("li").toggleClass('selected');
    });

    $("#private_submit").click(function(event)
    {
        answer_the_question(qa_id_clicked,$("#question_answer_new").val(),0);
    });

    $("#public_submit").click(function(event)
    {
        answer_the_question(qa_id_clicked,$("#question_answer_new").val(),1);
    });
});

//Not working - Find Date Time
function getDateTime(unixTimestamp)
{
    var now     = new Date(unixTimestamp * 1000); 
    var year    = now.getFullYear();
    var month   = now.getMonth()+1; 
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds(); 
    if(month.toString().length == 1) {
        var month = '0'+month;
    }
    if(day.toString().length == 1) {
        var day = '0'+day;
    }   
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }   
    var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;
    var dateTime = month+'/'+day+' '+hour+':'+minute+':'+second;
    return dateTime;
}

function answer_the_question(qa_id,answer,private_public)
{
    $.ajax(
    {
        headers: { 'X-CSRF-TOKEN': token},
        url: baseURL+"post_panelist_update_answer",
        success: function(result)
        {
            alert(result);
            $( "#qa_answer_area" ).hide("easing");
        },
        method: "POST",
        data:
        {
            _token          : token,
            qa_id           : qa_id,
            answer          : answer,
            private_public  : private_public
        }
    });
}

setInterval(function()
{
    $.ajax(
    {
        headers: { 'X-CSRF-TOKEN': token},
        url: baseURL+"post_qa_public_panelist",
        success: function(result)
        {
            //$( "#public_questions" ).empty();

            $.each(result, function(index, element)
            {
                var answer,name_answer,name_question,question,question_answered_before,question_ask_before,question_id;
                $.each(element,function(key,value)
                {
                    if(key.localeCompare('answer')==0)
                    {
                        answer=value;
                    }
                    else if(key.localeCompare('name_answer')==0)
                    {
                        name_answer=value;
                    }
                    else if(key.localeCompare('name_question')==0)
                    {
                        name_question=value;
                    }
                    else if(key.localeCompare('question')==0)
                    {
                        question=value;
                    }
                    else if(key.localeCompare('question_answered_before')==0)
                    {
                        question_answered_before=value;
                    }
                    else if(key.localeCompare('question_ask_before')==0)
                    {
                        question_ask_before=value;
                    }
                    else if(key.localeCompare('question_id')==0)
                    {
                        question_id=value;
                    }
                });

                console.log(element);

                $('#public_questions').append(
                                                $('meta[name=after_start_berore_question_id]').attr("content")
                                                +question_id
                                                +$('meta[name=after_question_id_berore_question]').attr("content")
                                                +question
                                                +$('meta[name=after_question_before_questioneer_name]').attr("content")
                                                +name_question
                                                +$('meta[name=after_questioneer_name_before_ask_before]').attr("content")
                                                +question_ask_before
                                                +$('meta[name=after_ask_before_before_answer_id]').attr("content")
                                                +question_id
                                                +$('meta[name=after_answer_id_before_answer]').attr("content")
                                                +answer
                                                +$('meta[name=after_answer_before_panelist_name]').attr("content")
                                                +name_answer
                                                +$('meta[name=after_panelist_name_before_answer_time]').attr("content")
                                                +question_answered_before
                                                +$('meta[name=after_panelist_name_before_end]').attr("content")
                                            );

            });
        },
        method: "POST",
        data:
        {
            _token          :         token,
            webinar_id      :         $('meta[name=webniar_ID_int]').attr("content")
        }
    });
}, 5000);