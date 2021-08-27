  
function loginValidation()
{
    var username = $.trim($("#username").val());

    var password = $.trim($("#password").val());

    if(username == "" || username == null)
    {
        $("#username_error").text("* Username is required").css("color", "red");
    }
    else if(username.length < 6)
    {
        $("#username_error").text("* Username should be 5 character long.").css("color", "red");
    }
    else
    {
        $("#username_error").text("");
    }

      if(password == "" || password == null)
    {
        $("#password_error").text("* Password is required").css("color", "red");
    }

    else if(password.length < 6)
    {
        $("#password_error").text("* Password should be 6 character long.").css("color", "red");
    }

    else
    {   
    $("#password_error").text(""); 
    }


      if(username == "" || username == null || password == "" || password == null || username.length < 6 || password.length < 6)
    {
        return false;
    }


}

