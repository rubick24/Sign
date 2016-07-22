/**
 * Created by Deada on 2016/7/21.
 */

$("#signBtn").click(function() {
    var data="code=1&userinput="+$('#userInput').val()+"&password="+$('#Password').val();
    $.post(
        "Controller.php",
        data,
        function (result) {
            result=strToJson(result);
            if (result.status){
                $('#signModal').modal('hide');
                var userStatus=$("#userStatus");
                userStatus.empty();
                userStatus.append("<p class=\"navbar-text\">Signed in as</p><li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">"+result.username+"<span class=\"caret\"></span></a><ul class=\"dropdown-menu\"><li><a href=\"#\">Your Profile</a></li><li role=\"separator\" class=\"divider\"></li><li><a href=\"#\" id=\"signOut\">Sign out</a></li></ul></li>");
                window.location.reload();
            }
            else {
                var errorBox=$('#errorBox');
                errorBox.empty();
                errorBox.append("<div class=\"alert alert-danger\" role=\"alert\">Sign in failed</div>");
            }
        }
    )
});

$("#signOut").click(function () {
    $.post(
        "Controller.php",
        "code=2&SignOut=true",
        function () {
            location.href = "index.php";
        }
    );
});

var checku = 0;
var checke = 0;
var checkp = 0;
var signUpBtn = $("#signUpBtn");
$("#username").blur(function () {
    $.post(
        "Controller.php",
        "code=3&username="+$('#username').val(),
        function (result) {
            result=strToJson(result);
            var usernameMsg = $('#usernameMsg');
            if(result.status){
                usernameMsg.empty();
                usernameMsg.append("<span class=\"glyphicon glyphicon-ok-sign\" style='color:limegreen'></span>");
                checku=1;
                if(checku&&checke&&checkp){
                    signUpBtn.attr("class","btn btn-primary pull-right");
                }
            }
            else {
                usernameMsg.empty();
                usernameMsg.append("<span class=\"glyphicon glyphicon-remove-sign  \" style='color:crimson'></span>"+result.msg);
                checku=0;
                signUpBtn.attr("class","btn btn-primary pull-right disabled");
            }
        }
    )
});
$("#email").blur(function () {
    var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var email = $('#email').val();
    if(preg.test(email)){
        $.post(
            "Controller.php",
            "code=4&email="+email,
            function (result) {
                result=strToJson(result);
                var emailMsg = $('#emailMsg');
                if(result.status){
                    emailMsg.empty();
                    emailMsg.append("<span class=\"glyphicon glyphicon-ok-sign\" style='color:limegreen'></span>");
                    checke=1;
                    if(checku&&checke&&checkp){
                        signUpBtn.attr("class","btn btn-primary pull-right");
                    }
                }
                else {
                    emailMsg.empty();
                    emailMsg.append("<span class=\"glyphicon glyphicon-remove-sign \" style='color:crimson'></span>"+result.msg);
                    checke=0;
                    signUpBtn.attr("class","btn btn-primary pull-right disabled");
                }
            }
        )
    }
    else {
        var emailMsg = $('#emailMsg');
        emailMsg.empty();
        emailMsg.append("<span class=\"glyphicon glyphicon-remove-sign \" style='color:crimson'></span>wrong email format");
        checke=0;
        signUpBtn.attr("class","btn btn-primary pull-right disabled");
    }
});
$("#cPassword").blur(function () {
    var cPasswordMsg = $("#cPasswordMsg");
    if($("#cPassword").val().length>=6){
        cPasswordMsg.empty();
        cPasswordMsg.append("<span class=\"glyphicon glyphicon-ok-sign\" style='color:limegreen'></span>")
    }
    else {
        cPasswordMsg.empty();
        cPasswordMsg.append("<span class=\"glyphicon glyphicon-remove-sign \" style='color:crimson'></span>password strength is weak");
    }
    checkPassword();
});
$("#rcPassword").blur(function () {
    checkPassword();
});
signUpBtn.click(function () {
    var msgBox = $("#MsgBox");
    if(checkPassword()){
        var data = "code=5&username="+$("#username").val()+"&email="+$("#email").val()+"&password="+$("#cPassword").val();
        $.post(
            "Controller.php",
            data,
            function (result) {
                result=strToJson(result);
                if (result.status){
                    signUpBtn.attr("class","btn btn-primary pull-right disabled");
                    signUpBtn.empty();
                    signUpBtn.append("Please wait");
                    msgBox.empty();
                    msgBox.append("<div class=\"alert alert-success\" role=\"alert\"><b>Success</b>sign up success(close in seconds)</div>");
                    setTimeout(function () {
                        $("#signUpModal").modal('hide')
                    } ,1500);
                }
                else {
                    msgBox.empty();
                    msgBox.append("<div class=\"alert alert-danger\" role=\"alert\"><b>Failed</b>unknown error</div>");
                }
            }
        );
    }
});


function checkPassword() {
    var rcPasswordMsg = $("#rcPasswordMsg");
    if($("#rcPassword").val()==$("#cPassword").val()){
        rcPasswordMsg.empty();
        rcPasswordMsg.append("<span class=\"glyphicon glyphicon-ok-sign\" style='color:limegreen'></span>");
        checkp=1;
        if(checku&&checke&&checkp){
            signUpBtn.attr("class","btn btn-primary pull-right");
            return true;
        }
        return false;
    }
    else {
        rcPasswordMsg.empty();
        rcPasswordMsg.append("<span class=\"glyphicon glyphicon-remove-sign \" style='color:crimson'></span>password don\'t same");
        checkp=0;
        signUpBtn.attr("class","btn btn-primary pull-right disabled");
        return false;
    }
}
function strToJson(str){
    return JSON.parse(str);
}