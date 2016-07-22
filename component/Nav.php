<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="Nav">
    <nav class="navbar navbar-default" style="margin-bottom: 0" >
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php"><p><img width="28px" style="margin: -5px 10px 0 10px" src="resource/Archlogo.svg">   Logo</p></a>
            </div>
            <div class="navb ar-collapse">
                <ul class="nav navbar-nav navbar-right" id="userStatus">
                    <?php
                    if(isset($_SESSION['uid'])&&!empty($_SESSION['uid'])){
                        $user = new User();
                        $user = $user->getUserInfo($_SESSION['uid']);
                        echo
                            "<li class='dropdown'>".

                            "<a href='' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>".
                                "<div class='circle'>". strtoupper(substr($user->username,0,1))."</div>"."<span class='caret'></span></a>".
                            "<ul class='dropdown-menu'>".
                            "<li><a>Signed in as <b>".$user->username."</b></a></li>".
                            "<li role='separator' class='divider'></li>".
                            "<li><a href='".$user->username."'>Your profile</a></li>".
                            "<li><a href=''>Action</a></li>".
                            "<li><a href=''>Another action</a></li>".
                            "<li role='separator' class='divider'></li>".
                            "<li><a href='' id='signOut'>Sign out</a></li></ul></li>";
                    }
                    else echo "<div class='btn-group' style='padding: 0 10px'><button type=\"button\" class=\"btn navbar-btn btn-info\" data-toggle=\"modal\" data-target=\"#signUpModal\">Sign up</button><button type=\"button\" class=\"btn btn-primary navbar-btn\" data-toggle=\"modal\" data-target=\"#signModal\">Sign in</button></div>"
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
</div>

</body>
</html>