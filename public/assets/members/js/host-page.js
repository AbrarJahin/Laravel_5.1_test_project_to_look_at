$("body").on('click','#updateShare',function () {

    var text = $('#shareContainer').val();

    $.ajax($('meta[name=base_url]').attr("content")+'/post_webinar_share_update', {
        'method': "post",
        'data': {
            "text":text,
            "webinarId":$('meta[name=webinar_id_int]').attr("content")
        }
    })

});

resetQaTable();

resetStatsTable();

function resetQaTable() {
    $.ajax($('meta[name=base_url]').attr("content")+'/get_webinar_answered_qa',{
        'method': "post",
        'data':{
            "webinarId":$('meta[name=webinar_id_int]').attr("content")
        },
        'success': function(data){
            var html = '';
            for(i = 0; i < data.questions.length; i++) {
                var qa = data.questions[i];
                if(qa.answer == null){
                    qa.answer = '';
                }
                html += '<li class="list-group-item">Que: '+qa.question+'</li> \
                         <li class="list-group-item list-group-item-info">Ans: '+qa.answer+'</li>';
            }

            if(!data.questions.length){
                html = '<li class="list-group-item">No Questions Yet</li>';
            }

            if(data.questions === undefined){
                html = '<li class="list-group-item alert-error">Error Occured</li>';
            }

            $('#qa-container').html(html);
            console.log('QA Table Updated');

        }
    })
}

function resetStatsTable(){

    $.ajax($('meta[name=base_url]').attr("content")+'/get_webinar_stats',{
        'method': "post",
        'data':{
            "webinarId":$('meta[name=webinar_id_int]').attr("content")
        },
        'success': function(data){
            var sum = 0;
            var html = '';
            for(i = 0; i < data.subscribers.length; i++) {
                var list = data.subscribers[i];
                html += '<li class="list-group-item"><span class="badge">'+list.count+'</span>'+list.name+'</li>';
                sum += list.count
            }
            html = '<li class="list-group-item"><span class="badge">'+sum+'</span>Total Subscribers</li>' + html;

            $('#attenders-stats').html(html);

            html = '';
            for(i = 0; i < data.questions.length; i++) {
                var question = data.questions[i];
                html += '<li class="list-group-item"><span class="badge">'+question.count+'</span>'+question.name+'</li>';
            }
            $('#questions-stats').html(html);

            html = '';
            for(i = 0; i < data.panelists.length; i++) {
                var panelist = data.panelists[i];
                html += '<li class="list-group-item"><span class="badge">'+panelist.count+'</span>'+panelist.name+'</li>';
            }
            $('#panelists-stats').html(html);
            console.log('Stats Table Updated');

        }
    })

}

setInterval(function(){
    resetQaTable();
    resetStatsTable();
}, 5000);