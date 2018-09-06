import 'webpack-jquery-ui/css'
import 'webpack-jquery-ui/datepicker'
$(document).ready(function()
{
    //Define both datepicker widgets and make sure their values affect each other's limits
    $("#from").datepicker(
    {
          changeMonth: true,
          dateFormat: 'dd.mm.yy'
    }).on("change", function() 
    {
        $("#to").datepicker("option", "minDate", $(this).datepicker('getDate'));
    });
    $("#to").datepicker(
    {
        changeMonth: true,
        dateFormat: 'dd.mm.yy'
    }).on("change", function()
    {
        $("#from").datepicker("option", "maxDate", $(this).datepicker('getDate'));
    });
    
    //Add the interactivity of the first, prev, next and last buttons in the paginator
    $('#first').attr('disabled', 'disabled').click(function()
    {
        $('#numerator').text(1);
        $('#first, #prev').attr('disabled', 'disabled');
        $('#next, #last').removeAttr('disabled');
        fetch();
    });
    $('#prev').attr('disabled', 'disabled').click(function()
    {
        var numerator = parseInt($('#numerator').text());
        var denominator = parseInt($('#denominator').text());
        numerator--;
        if (denominator === 1)
        {
            $('#first, #prev').attr('disabled', 'disabled');
            $('#next, #last').removeAttr('disabled');
        }
        else
        {
            $('#first, #prev').removeAttr('disabled');
        }
        $('#numerator').text(numerator);
        fetch();
    });
    $('#next').click(function()
    {
        var numerator = parseInt($('#numerator').text());
        var denominator = parseInt($('#denominator').text());
        numerator++;
        if (denominator === numerator)
        {
            $('#next, #last').attr('disabled', 'disabled');
            $('#first, #prev').removeAttr('disabled');
        }
        else
        {
            $('#next, #last').removeAttr('disabled');
        }
        $('#numerator').text(numerator);
        fetch();
    });
    $('#last').click(function()
    {
        $('#numerator').text($('#denominator').text());
        $('#first, #prev').removeAttr('disabled');
        $('#next, #last').attr('disabled', 'disabled');
        fetch();
    });
    
    //Filter button option for when filter values are changed
    $('#filter').click(function(){fetch();});
});

//This function makes the AJAX request to the server
function fetch()
{
    $.ajax(
    {
        url: '/fetch',
        type: 'POST',
        dataType: 'json',
        data:
        {
            from: $('#from').val(),
            to: $('#to').val(),
            terms: $.trim($('#terms').val()),
            order: $('#order').val(),
            descasc: $('#descasc').val(),
            numerator: parseInt($('#numerator').text())
        },
    }).done(function(data)
    {
        //Clear the table and dynamically add new rows containing the information retrieved from the server
        $('#storyTable').find('tbody').empty();
        for (var i = 0; i < data.stories.length; i++)
        {
            $('#storyTable').find('tbody')
                .append($('<tr>')
                    .append($('<td>', {'text': data.stories[i].id}))
                    .append($('<td>', {'text': data.stories[i].description}))
                    .append($('<td>', {'text': data.stories[i].bookTime}))
                    .append($('<td>', {'text': data.stories[i].submitDate})));
        }
    });
}