<?php
/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="js/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <script>
            $(document).ready(function () {
                // login
                $("#login").click(function () {
                    var email = $("#email").val();
                    var password = $("#password").val();
                    var errMSG = '';
                    // Checking for blank fields.
                    if (email === '') {
                        $('#email').css("border", "2px solid red");
                        $('#email').css("box-shadow", "0 0 3px red");
                        errMSG += 'Error: email missing!<br />';
                    }
                    if (password === '') {
                        $('#password').css("border", "2px solid red");
                        $('#password').css("box-shadow", "0 0 3px red");
                        errMSG += 'Error: password missing!<br />';
                    }
                    if (errMSG !== '') {
                        $("#errMSG").html(errMSG);
                    } else {
                        $.post("json_response.php?type=login",
                                {
                                    email: email,
                                    password: password
                                },
                                function (data) {
                                    if (data.payload === 1) {
                                        //alert("Success!");
                                        $('#nav', window.parent.document).html('Welcome ' + email + ', you can <span id="logout">[ logout here ]</span>');
                                        $('#logout', window.parent.document).css('color', '#008000');
                                        $('#logout', window.parent.document).css('font-weight', 'bold');
                                        $('#logout', window.parent.document).css( 'cursor', 'pointer' );
                                        location.reload();
                                    } else
                                        $("#errMSG").html("Error: username or password wrong!");
                                });
                    }
                });
                // register
                $("#register").click(function () {

                    var rname = $("#rname").val();
                    var remail = $("#remail").val();
                    var rpassword = $("#rpassword").val();
                    var rconfirmPassword = $("#rconfirmPassword").val();
                    var errMSG = '';
                    // Checking for blank fields.
                    if (rname === '') {
                        $('#rname').css("border", "2px solid red");
                        $('#rname').css("box-shadow", "0 0 3px red");
                        errMSG += 'Error: name missing!<br />';
                    }
                    if (remail === '') {
                        $('#remail').css("border", "2px solid red");
                        $('#remail').css("box-shadow", "0 0 3px red");
                        errMSG += 'Error: email missing!<br />';
                    }
                    if (rpassword === '') {
                        $('#rpassword').css("border", "2px solid red");
                        $('#rpassword').css("box-shadow", "0 0 3px red");
                        errMSG += 'Error: password missing!<br />';
                    }
                    if (rconfirmPassword === '') {
                        $('#rconfirmPassword').css("border", "2px solid red");
                        $('#rconfirmPassword').css("box-shadow", "0 0 3px red");
                        errMSG += 'Error: confirm password missing!<br />';
                    }

                    if (rpassword !== rconfirmPassword) {
                        alert("Your Passwords do not match!");
                        $('#rpassword').css("border", "2px solid red");
                        $('#rpassword').css("box-shadow", "0 0 3px red");
                        $('#rconfirmPassword').css("border", "2px solid red");
                        $('#rconfirmPassword').css("box-shadow", "0 0 3px red");
                        errMSG += 'Error: passwords do not match!<br />';
                    }

                    if (errMSG !== '') {
                        $("#errMSG").html(errMSG);
                    } else {
                        // lets insert the new user to the back-end
                        $.post("json_response.php?type=register",
                                {
                                    rname: rname,
                                    remail: remail,
                                    rpassword: rpassword
                                },
                                function (data) {
                                    // 1 success, 2 email exists error, 0 general error
                                    if (data.payload === 1) {
                                        //update log out link for parent window
                                        $('#nav', window.parent.document).html('Welcome ' + remail + ', you can <span id="logout">[ logout here ]</span>');
                                        $('#logout', window.parent.document).css('color', '#008000');
                                        $('#logout', window.parent.document).css('font-weight', 'bold');
                                        $('#logout', window.parent.document).css( 'cursor', 'pointer' );
                                        location.reload();
                                    } else {
                                        if (data.payload === 0)
                                            $("#errMSG").html("Error: oops, something went wrong!");
                                        if (data.payload === 2)
                                            $("#errMSG").html("Error: account already exists!");
                                    }
                                });
                    }
                });
                //if the error message changes make it noticable!
                $('#errMSG').bind("DOMSubtreeModified", function () {
                    function blink_text() {
                        $('#errMSG').fadeOut(1000);
                        $('#errMSG').fadeIn(1000);
                    }
                    setInterval(blink_text, 2000);
                });
                // tabs
                $(".tab").click(function ()
                {
                    //clear stale error msgs
                    $("#errMSG").html("");
                    var X = $(this).attr('id');
                    if (X === 'signup')
                    {
                        $("#login").removeClass('select');
                        $("#signup").addClass('select');
                        $("#loginbox").slideUp();
                        $("#signupbox").slideDown();
                    } else
                    {
                        $("#signup").removeClass('select');
                        $("#login").addClass('select');
                        $("#signupbox").slideUp();
                        $("#loginbox").slideDown();
                    }

                });
            });
        </script>  
        <div id="tabContainer">
            <div id="tabbox">
                <a href="#" id="signup" class="tab signup">Register</a>
                <a href="#" id="loginTab" class="tab select">Login</a>
            </div>
            <div id="panel">
                <div id="errMSG"></div>
                <div id="loginbox">
                    <form class="form" method="post" action="#">
                        <table>
                            <tr>
                                <td><label>Email:</label></td>
                                <td><input type="text" name="email" id="email"></td>
                            </tr>
                            <tr>
                                <td><label>Password:</label></td>
                                <td><input type="password" name="password" id="password"></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td align="right"><input type="button" name="login" id="login" value="Login"></td>
                            </tr>
                        </table>

                    </form>
                </div>
                <div id="signupbox">
                    <form class="form" method="post" action="#">
                        <table>
                            <tr>
                                <td><label>Name:</label></td>
                                <td><input type="text" name="rname" id="rname"></td>
                            </tr>
                            <tr>
                                <td><label>Email:</label></td>
                                <td><input type="text" name="remail" id="remail"></td>
                            </tr>
                            <tr>
                                <td><label>Password:</label></td>
                                <td><input type="password" name="rpassword" id="rpassword"></td>
                            </tr>
                            <tr>
                                <td><label>Confirm Password:</label></td>
                                <td><input type="password" name="rconfirmPassword" id="rconfirmPassword"></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td align="right">
                                    <input type="button" name="register" id="register" value="Register">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

        </div>
    </body>
</html>
