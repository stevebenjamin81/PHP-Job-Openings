<?php
/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
?><html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../js/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
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
                        $.post("../json_response.php?type=login",
                                {
                                    email: email,
                                    password: password
                                },
                                function (data) {
                                    if (data.payload === 1) {
                                        window.location = "index.php";
                                    } else
                                        $("#errMSG").html("Error: username or password wrong!");
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
                    if (X === 'info')
                    {
                        $("#login").removeClass('select');
                        $("#info").addClass('select');
                        $("#loginbox").slideUp();
                        $("#infobox").slideDown();
                    } else
                    {
                        $("#info").removeClass('select');
                        $("#login").addClass('select');
                        $("#infobox").slideUp();
                        $("#loginbox").slideDown();
                    }
                });
            });
        </script>  
        <div id="tabContainer">
            <div id="tabbox">
                <a href="#" id="info" class="tab info">Info</a>
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
                <div id="infobox">
                        <table>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                </div>
            </div>

        </div>
    </body>
</html>

