var interval = 0;
$(document).ready(function()
{
    //Ensure the field cannot be edited by default
    $('#form_bookTime').attr('readonly', 'readonly');
    
    //Enable or disable manual input by request
    $('#form_storyManual').change(function()
    {
        if(!$(this).is(":checked")) 
        {
            $('#form_bookTime').attr('readonly', 'readonly');
            $('#form_storyStart').removeAttr('disabled');
        }
        else
        {
            $('#form_bookTime').removeAttr('readonly');
            $('#form_storyStart').attr('disabled', 'disabled');
        }
    });
    
    //Timer function binding on a click
    $('#form_storyStart').click(function()
    {
        if ($(this).text() === 'Start timer')
        {
            $(this).text('Pause timer');
            $('#form_storySave').attr('disabled', 'disabled');
            interval = setInterval(updateTimer, 1000);
        }
        else
        {
            $(this).text('Start timer');
            $('#form_storySave').removeAttr('disabled');
            clearInterval(interval);
        }
    });
    
    //Reset the clock if needed
    $('#form_storyReset').click(function()
    {
        $('#form_bookTime').val('0:00:00');
    });
    //Verfy the form is correct and send the data to the server via AJAX
    $('#form_storySave').click(function()
    {
        //validation variables
        var valid = true;
        var message = '';
        
        //trim the description before validating
        $('#form_description').val($.trim($('#form_description').val()));
        
        //In case the user manually inputted the time, run a check so it is correct
        if ($('#form_storyManual').is(":checked"))
        {
            var match = $('#form_bookTime').val().search(/[0-9]:[0-5][0-9]:[0-5][0-9]/);
            if (match === -1)
            {
                valid = false;
                message += "Invalid time format\n";
            }
        }
        //No empty descriptions allowed
        if ($('description').val() === '')
        {
            valid = false;
            message += "Please describe the story";
        }
        //validation succeeded
        if (valid === true)
        {
            $.ajax(
            {
                url: '/add',
                type: 'POST',
                dataType: 'json',
                data:
                {
                    time: $('#form_bookTime').val(),
                    description: $('#form_description').val(),
                },
            }).done(function(data)
            {
                $('#feedback').html(data.feedback);
                if (data.success === 1)
                {
                    cleanForm();
                }
            });
        }
        else //validation failed
        {
            alert(message);
        }
    });
});

//The function that does update the timer when it is started
function updateTimer()
{
    var timeArray = $('#form_bookTime').val().split(":");
    if (parseInt(timeArray[2]) === 59)
    {
        timeArray[2] = '00';
        if (parseInt(timeArray[1]) === 59)
        {
            timeArray[1] = '00';
            timeArray[0] = parseInt(timeArray[0])+1;
        }
        else
        {
            timeArray[1] = parseInt(timeArray[1])+1;
            if (timeArray[1] < 10)
            {
                timeArray[1] = '0'+timeArray[1];
            }
        }
    }
    else
    {
        timeArray[2] = parseInt(timeArray[2])+1;
        if (timeArray[2] < 10)
        {
            timeArray[2] = '0'+timeArray[2];
        }
    }
    $('#form_bookTime').val(timeArray[0]+':'+timeArray[1]+':'+timeArray[2]);
}

//Full form cleaning after a successful submission
function cleanForm()
{
     $('#form_bookTime').val('0:00:00');
     $('#form_description, #feedback').val('');
     $('#form_storyManual').removeAttr('checked');
}