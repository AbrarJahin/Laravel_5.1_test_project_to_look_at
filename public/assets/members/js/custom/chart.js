var url                   = window.location.href;
var userId                = (url.match(/\/users\/(\d+)\//) || [])[1];
var subscribers_lists_Id  = (url.match(/\/subscribers-lists\/(\d+)\//) || [])[1];
google.load("visualization", "1", {packages:["corechart"]});

/*
setInterval(function()
{
    if($("#piechart_voting").length != 0)
    {
      drawData_voting();
    }
}, 2000);
*/

setInterval(function()                      //Set Auto Refresh in every 5s
{
    if($("#line_chart").length != 0)     //if the div exists
    {
        drawLineChart('line_chart',$('meta[name=base_url]').attr("content")+'/'+'post_user_status_chart');
    }
}, 20000);

//////////////////////////////////////////////////////////////////////////////////////////////For Total Statistics in http://localhost/gtwhero/public/users/3/subscribers-lists
function drawData_piechart_total()
{
  var data = new google.visualization.arrayToDataTable(getAJAXData_piechart_total('Task','Hours per Day'));
  //var data = new google.visualization.DataTable(jsonData);
  var options = {
                  title: 'Total Statistics of Subscriber List',
                  is3D: true,
                  width: '100%',
                  height: '100%',
                  chartArea:
                  {
                      left: "0%",
                      top: "10%",
                      height: "90%",
                      width: "100%"
                  }
                };
  var chart = new google.visualization.PieChart(document.getElementById('piechart_total'));
  chart.draw(data, options);
}

function getAJAXData_piechart_total(title_header,value_object)
{
  var jsonData = $.ajax({
                          method: "POST",
                          url: $('meta[name=base_url]').attr("content")+'/'+"post_chart_data_total",
                          dataType: "json",
                          async: false,
                          data:
                          {
                            user_id:                 userId
                          },
                        }).responseText;
  /////////////////////////////////////////////
  var obj = JSON.parse(jsonData);
  //Received from AJAX is like - {"Work":11,"Eat":2,"Commute":2,"Watch TV":2,"Sleep":7}
  var dataArray =[[title_header, value_object]];

  for (var key in obj)
  {
      dataArray.push([key, parseInt(obj[key])]);
  }
  return dataArray;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////

$(document).ready(function()
{
  $("#refresh_current_question_data").click(function()
  {
    if($("#piechart_voting").length != 0)
    {
      alert('Voting Chart Refreshed!');
      drawData_voting();
    }
  });

  $("#reset_current_question_data").click(function()
  {
    console.log('reset_clicked');
    var message = $.ajax({
                        method: "POST",
                        url: $('meta[name=base_url]').attr("content")+'/'+"reset_votes",
                        dataType: "json",
                        async: false,
                        data:
                        {
                          uuid             :   $('meta[name=webinar_id_int]').attr("content"),
                          user_id          :   3
                        },
                      }).responseText;;
    alert(message);
  });
});

$(function()
{
  console.log("loaded");
  if($("#piechart").length != 0)      //Preventing unusual data loading ERROR with if-else
  {
    drawData();
  }
  if($("#piechart_voting").length != 0)
  {
    drawData_voting();
  }
  if($("#piechart_total").length != 0)
  {
    drawData_piechart_total();
  }
});

$( window ).resize(function()
{
  console.log("resized");
  if($("#piechart").length != 0)
  {
    drawData();
  }
});

function drawData()
{
  var data = new google.visualization.arrayToDataTable(getAJAXData('Task','Hours per Day'));
  //var data = new google.visualization.DataTable(jsonData);
  var options = {
                  title: 'According to Status',
                  is3D: true,
                  width: '100%',
                  height: '100%',
                  chartArea:
                  {
                      left: "0%",
                      top: "10%",
                      height: "90%",
                      width: "100%"
                  }
                };
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}

function getAJAXData(title_header,value_object)
{
  var jsonData = $.ajax({
                          method: "POST",
                          url: $('meta[name=base_url]').attr("content")+'/'+"post_chart_data",
                          dataType: "json",
                          async: false,
                          data:
                          {
                            user_id:                 userId,
                            subscribers_lists_Id:   subscribers_lists_Id
                          },
                        }).responseText;
  /////////////////////////////////////////////
  var obj = JSON.parse(jsonData);
  //Received from AJAX is like - {"Work":11,"Eat":2,"Commute":2,"Watch TV":2,"Sleep":7}
  var dataArray =[[title_header, value_object]];

  for (var key in obj)
  {
      dataArray.push([key, parseInt(obj[key])]);
  }
  return dataArray;
}

function drawData_voting()
{
  var data = new google.visualization.arrayToDataTable(getAJAXData_voting('Task','Hours per Day'));
  //var data = new google.visualization.DataTable(jsonData);
  var options = {
                  title: 'Voting Result',
                  is3D: true,
                  width: '100%',
                  height: '100%',
                  chartArea:
                  {
                      left: "0%",
                      top: "10%",
                      height: "90%",
                      width: "100%"
                  }
                };
  var chart = new google.visualization.PieChart(document.getElementById('piechart_voting'));
  chart.draw(data, options);
}

function getAJAXData_voting(title_header,value_object)
{
  var jsonData = $.ajax({
                          method: "POST",
                          url: $('meta[name=base_url]').attr("content")+'/'+"post_chart_data_voting",
                          dataType: "json",
                          async: false,
                          data:
                          {
                            uuid             :   $('meta[name=webinar_id_int]').attr("content"),
                            subscribers_lists_Id:   3
                          },
                        }).responseText;
  /////////////////////////////////////////////
  var obj = JSON.parse(jsonData);
  //Received from AJAX is like - {"Work":11,"Eat":2,"Commute":2,"Watch TV":2,"Sleep":7}
  var dataArray =[[title_header, value_object]];

  for (var key in obj)
  {
      dataArray.push([key, parseInt(obj[key])]);
  }
  return dataArray;
}

///////////////////////////////////////////////////////////////////////Line Chart JS///////////////////////////////////

$(function ()                                               //Document Ready
{
    if($("#line_chart").length != 0)     //if the div exists
    {
        drawLineChart('line_chart',$('meta[name=base_url]').attr("content")+'/'+'post_user_status_chart');
    }
});

function drawLineChart(div_id,ajax_source)
{
    $('#'+div_id).highcharts(
    {
        credits:
        {
          enabled: false
        },
        chart:
        {
            type: 'spline'
        },
        plotOptions:
        {
            /*series:                 //Stopping the animation
            {
                animation: false
            },*/
            spline:
            {
                marker:
                {
                    enabled: true
                }
            }
        },
        title:
        {
            text: 'No of Users vs Time'
        },
        subtitle:
        {
            text: 'Toatl no of attenders in this webinar'
        },
        xAxis:
        {
            type: 'datetime',
            title:
            {
                text: 'Time'
            }
        },
        yAxis:
        {
            title:
            {
                text: 'Snow depth (m)'
            },
            min: 0
        },
        tooltip:
        {
            headerFormat: '<b>{series.name} :<br/> {point.x:%e %b,%Y - %H:%M:%S}</b><br>',
            pointFormat: '{point.y:.0f} Users Online'
        },
        series: get_ajax_data(ajax_source)
    });
}

function get_ajax_data(ajax_source)
{
    var jsonData = $.ajax({
                          method: "POST",
                          url: ajax_source,
                          dataType: "json",
                          async: false,
                          data:
                          {
                            webinar_id:   $('meta[name=webinar_id_int]').attr("content"),
                            no_of_points: $('#no_of_points_to_show').val()
                          }
                        }).responseText;

    var total_data_from_AJAX = [];
    $.each($.parseJSON(jsonData), function(index, element)
    {
        var name = "";
        var temp_AJAX_data=[];
        $.each(element,function(key_array,value_array)
        {
            if(key_array.localeCompare('name')==0)
            {
                name=value_array;
            }
            else if(key_array.localeCompare('data')==0)
            {
                $.each(value_array,function(key_temp,value_temp)
                {
                    var time_year=0,time_month=0,time_day=0,time_hour=0,time_min=0,time_sec=0,value_of_data=0;
                    $.each(value_temp,function(key,value)
                    {
                        if(key.localeCompare('time_year')==0)
                        {
                            time_year=value;
                        }
                        else if(key.localeCompare('time_month')==0)
                        {
                            time_month=value;
                        }
                        else if(key.localeCompare('time_day')==0)
                        {
                            time_day=value;
                        }
                        else if(key.localeCompare('time_hour')==0)
                        {
                            time_hour=value;
                        }
                        else if(key.localeCompare('time_min')==0)
                        {
                            time_min=value;
                        }
                        else if(key.localeCompare('time_sec')==0)
                        {
                            time_sec=value;
                        }
                        else if(key.localeCompare('value')==0)
                        {
                            value_of_data=value;
                        }
                    });
                    temp_AJAX_data.push([Date.UTC(time_year, time_month,time_day,time_hour,time_min,time_sec), value_of_data]);
                });
            }
        });
        total_data_from_AJAX.push(
                                    {
                                        name: name,
                                        data: temp_AJAX_data
                                    }
                                );
    });

    return total_data_from_AJAX;
}