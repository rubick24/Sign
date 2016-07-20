<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/17
 * Time: 14:20
 */
require_once './Database.php';
require_once './User.php';
require_once './ProjectForm.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="resource/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="resource/main.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-default" style="margin-bottom: 0" >
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Logo</a>
            </div>
            <div class="navbar-collapse">
                <ul class="nav navbar-nav navbar-right" id="userStatus">
                <?php
                if(isset($_SESSION['uid'])&&!empty($_SESSION['uid'])){
                    $user = new User();
                    $user = $user->getUserInfo($_SESSION['uid']);
                    echo "<p class=\"navbar-text\">Signed in as</p><li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">".$user->username."<span class=\"caret\"></span></a><ul class=\"dropdown-menu\"><li><a href=\"#\">Action</a></li><li role=\"separator\" class=\"divider\"></li><li><a href=\"#\" id=\"signOut\">Sign out</a></li></ul></li>";
                }
                else echo "<div class='btn-group'><button type=\"button\" class=\"btn navbar-btn btn-info\" data-toggle=\"modal\" data-target=\"#signUpModal\">Sign up</button><button type=\"button\" class=\"btn btn-primary navbar-btn\" data-toggle=\"modal\" data-target=\"#signModal\">Sign in</button></div>"
                ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="signModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="signModalLabel">Sign In</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="userInput">Username or email address</label>
                        <input type="text" class="form-control" id="userInput" >
                    </div>
                    <div class="form-group" >
                        <label for="Password">Password</label>
                        <a class="pull-right" style="font-size: 12px" href="#" content="Password">Forgot password?</a>
                        <input type="password" class="form-control" id="Password" >
                    </div>
                    <div class="form-group">
                        <a href="#"></a>
                    </div>
                    <div class="form-group" id="errorBox"></div>
                    <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                    <button id="signBtn" class="btn btn-primary pull-right">Sign in</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="signUpModalLabel">Sign Up</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <p class="pull-right" id="usernameMsg"></p>
                        <input type="text" class="form-control" id="username" >
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <p class="pull-right" id="emailMsg"></p>
                        <input type="text" class="form-control" id="email" >
                    </div>
                    <div class="form-group" >
                        <label for="cPassword">Password</label>
                        <p class="pull-right" id="cPasswordMsg"></p>
                        <input type="password" class="form-control" id="cPassword" >
                    </div>
                    <div class="form-group" >
                        <label for="rcPassword">Confirm password</label>
                        <p class="pull-right" id="rcPasswordMsg"></p>
                        <input type="password" class="form-control" id="rcPassword" >
                    </div>
                    <div class="form-group" id="MsgBox"></div>
                    <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                    <button id="signUpBtn" class="btn btn-primary pull-right disabled">Sign up</button>
                </div>
            </div>
        </div>
    </div>

    <div class="jumbotron" id="MainJum" style="height: 550px;" >
        <div class="container" >
            <h1>Title</h1>
            <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
            <!--<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>-->
        </div>
    </div>
    <?php

    ?>


    <script type="text/javascript" src="resource/jquery.min.js"></script>
    <script type="text/javascript" src="resource/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
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
                    window.location.reload();
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
    </script>
</body>
</html>