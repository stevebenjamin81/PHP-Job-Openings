<?php

/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
require 'secure.php';
?><html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/jquery.fancybox.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/jquery.fancybox.min.css">
    </head>
    <body>
        <script>
            function del(id, tab, rtoggle) {
                if (window.confirm("Are you sure?")) {
                    $.post("../json_response.php?type=delete",
                            {
                                id: id,
                                table: tab
                            },
                            function (data) {
                                if (data.payload === 1) {
                                    $("#serverResponse").html("SYSTEM MSG: Entry Deleted!");
                                    $(rtoggle + id).toggle();
                                } else
                                    $("#serverResponse").html("SYSTEM MSG: Something went wrong!");
                            });
                    setTimeout(
                            function ()
                            {
                                $("#serverResponse").html("");
                            }, 2000);
                }
            }
            ;

            function saveUser(id) {

                if (window.confirm("Are you sure?")) {
                    var is_admin = $("#uAdmin" + id).val();
                    var name = $("#uName" + id).val();
                    var email = $("#uEmail" + id).val();
                    $.post("../json_response.php?type=saveUser",
                            {
                                id: id,
                                is_admin: is_admin,
                                name: name,
                                email: email
                            },
                            function (data) {
                                if (data.payload === 1) {
                                    $("#serverResponse").html("SYSTEM MSG: Entry Saved!");
                                } else
                                    $("#serverResponse").html("SYSTEM MSG: Something went wrong!");
                            });

                    setTimeout(
                            function ()
                            {
                                $("#serverResponse").html("");
                            }, 2000);
                }
            }
            $(document).ready(function () {
                $('#nav').html('Welcome back <?= $_SESSION['name'] ?>, you can <span id="logout">[ logout here ]</span>');
                $('#logout').css('color', '#008000');
                $('#logout').css('font-weight', 'bold');
                $('#logout').css('cursor', 'pointer');
                $(document).on("click", "#logout", function () {
                    $.getJSON("../json_response.php?type=logout", function () {
                        $("#nav").html("");
                        location.reload();
                    });
                });
                // lets keep the panes even
                $('#rightpane').css('height', $("#leftpane").height());
                $('#leftpane').css('width', $("#adminUL").width() + 20);
                $('#rightpane').css('width', $("#container").width() - ($("#adminUL").width() + 80));
                $('#rightpane').css('overflow-y', 'auto');
                $(window).on('resize', function () {
                    $('#rightpane').css('width', $("#container").width() - ($("#adminUL").width() + 80));

                });
                $("#applicants").click(function () {
                    $("#categories").html('');
                    $("#positions").html("");
                    $("#usr").html("");
                    //categories
                    $.getJSON("../json_response.php?type=categories", function (data) {
                        var items = [];
                        $("#position").html("<h2>Select a Postion</h2>");
                        $.each(data.payload, function () {
                            $.each(this, function (key, val) {
                                var str = '';
                                if (key === 'id') {
                                    str += '<li id="' + val + '" class="adminCatLi">';
                                }
                                if (key === 'name') {
                                    str += val + "</li>\n";
                                }
                                items.push(str);
                            });
                        });
                        $("#categories").html('<div style="margin-left:12px;">' +
                                '</div><h2>Applicant Categories</h2><ul id="adminCatUL">' +
                                items.join("") + '</ul>');
                    });
                    $(document).on("click", ".adminCatLi", function () {
                        //positions
                        $.getJSON("../json_response.php?type=jobs&category_id=" + this.id, function (data) {
                            var items = [];
                            $.each(data.payload, function () {
                                $.each(this, function (key, val) {
                                    var str = '';
                                    if (key === 'id') {
                                        str += '<li class="adminJobLi"><a data-fancybox data-type="iframe" data-src="applicants.php?jobs_id=' + val + '" href="javascript:void(0)">';
                                    }
                                    if (key === 'name') {
                                        str += val + "</a></li>";
                                    }
                                    items.push(str);
                                });
                            });
                            $("#positions").html('<ul id="adminJobUL">' + items.join("") + '</ul>');
                            $("#positions").prepend("<h2>Applicant Postions</h2>");
                            $('#positions').css('text-align', "left");
                        });
                    });
                });
                // edit category
                $("#cat").click(function () {
                    $("#positions").html("");
                    $("#usr").html("");
                    $.getJSON("../json_response.php?type=categories", function (data) {
                        var items = [];
                        var id = '';
                        $.each(data.payload, function () {
                            $.each(this, function (key, val) {
                                var str = '';
                                if (key === 'id') {
                                    id = val;
                                }
                                if (key === 'name') {
                                    str += '<tr id="category' + id + '"><td>' + val + '</td><td><button type="button" data-fancybox data-type="iframe" data-src="editor.php?&categories_id=' + id + '" href="javascript:;">Edit</button>';
                                    str += ' <button onclick="del(' + id + ', \'categories\', \'#categoriesTable tr#category\')">Delete</button></td></tr>';
                                }
                                items.push(str);
                            });
                        });
                        $("#categories").html('<h2>Categories <button data-fancybox data-type="iframe" data-src="add.php?type=category">Add</button></h2><table id="categoriesTable" spacing="10" width="80%" align="center">' + items.join("") + '</table>');
                    });
                });
                //edit jobs
                $("#pos").click(function () {
                    $("#categories").html("");
                    $("#usr").html("");
                    $.getJSON('../json_response.php?type=jobs&category_id=*', function (data) {
                        var items = [];
                        var id = '';
                        $.each(data.payload, function () {
                            $.each(this, function (key, val) {
                                var str = '';
                                if (key === 'id') {
                                    id = val;
                                }
                                if (key === 'name') {
                                    str += '<tr id="job' + id + '"><td>' + val + '</td><td><button type="button" data-fancybox data-type="iframe" data-src="editor.php?&jobs_id=' + id + '" href="javascript:;">Edit</button>';
                                    str += ' <button onclick="del(' + id + ', \'jobs\', \'#jobsTable tr#job\')">Delete</button></td></tr>';
                                }
                                items.push(str);
                            });
                        });
                        $("#positions").html('<h2>Positions <button data-fancybox data-type="iframe" data-src="add.php?type=job">Add</button></h2><table id="jobsTable" spacing="10" width="80%" align="center">' + items.join("") + '</table>');
                    });
                });
                // users
                $("#users").click(function () {
                    $("#positions").html("");
                    $("#categories").html("");
                    $.getJSON('../json_response.php?type=users', function (data) {
                        var items = [];
                        var id = '';
                        var is_admin = '';
                        $.each(data.payload, function () {
                            $.each(this, function (key, val) {
                                var str = '';
                                if (key === 'id') {
                                    id = val;
                                }
                                if (key === 'is_admin') {
                                    is_admin = val;
                                    str += '<tr id="user' + id + '">' +
                                            '<td style="border: 1px solid #ccc; padding: 10px;">' +
                                            '<select id="uAdmin' + id + '" name="' + key + '" style="width:98%">' +
                                            '<option value="0">Standard User</option>' +
                                            '<option value="1"';
                                    if (val === '1') {
                                        str += ' SELECTED ';
                                    }
                                    str += '>Administrator</option>' +
                                            '<option value="2"';
                                    if (val === '2') {
                                        str += ' SELECTED ';
                                    }
                                    str += '>Super Administrator</option>' +
                                            '</select>' +
                                            '</td>';
                                }
                                if (key === 'name') {
                                    str += '<td style="border: 1px solid #ccc; padding: 10px;">' +
                                            '<input id="uName' + id + '" style="width:98%" type="text" name="' + key + '" value="' +
                                            val + '"></td>';
                                }
                                if (key === 'email') {
                                    str += '<td style="border: 1px solid #ccc; padding: 10px;">' +
                                            '<input id="uEmail' + id + '" style="width:98%" type="text" name="' + key + '" value="' +
                                            val + '"></td>' +
                                            '<td style="border: 1px solid #ccc; padding: 10px;">' +
                                            '<button onClick="saveUser(' + id + ');">Save</button> ';
                                    if (is_admin !== '2' && id !== '1') {
                                        str += ' <button onclick="del(' + id + ', \'users\', \'#usersTable tr#user\');" value="' + id + '">Delete</button>';
                                    }
                                    str += '</td></tr>';
                                }
                                items.push(str);
                            });
                        });
                        $("#usr").html('<h2>Users</h2>' +
                                '<table id="usersTable" spacing="10" style="width:96%; border: 1px solid #ccc; border-collapse: collapse;" align="center">' +
                                '<tr>' +
                                '<th style="border: 1px solid #ccc; text-align:left;">Admin</th>' +
                                '<th style="border: 1px solid #ccc; text-align:left;">Name</th>' +
                                '<th style="border: 1px solid #ccc; text-align:left;">Email</th>' +
                                '<th style="border: 1px solid #ccc; text-align:left;">Actions</th></tr>'
                                + items.join("") +
                                '</table>');
                    });
                });
                //lets put something up on page load
                $("#applicants").trigger("click");
            });

        </script>

        <h1>Administration Panel</h1>
        <div id="nav"></div>
        <div id="container">
            <div id="leftpane">

                <div id="adminUL">

                    <div>Actions</div>
                    <ul class="adminUL">
                        <li><a href="#" id="applicants">Applicants</a></li>
                        <li><a href="#" id="cat">Categories</a></li>
                        <li><a href="#" id="pos">Positions</a></li>
                        <?php if ($_SESSION['is_admin'] == '2') { ?>
                            <li><a href="#" id="users">Users</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div id="rightpane">
                <div id="serverResponse" 
                     style="text-align:center;
                     font-weight:bold;
                     margin:20px; 
                     font-size:22px; 
                     color:#008000"></div>
                <div id="categories"></div>
                <div id="positions"></div>
                <div id="usr"></div>
                <div id="applicants"></div>
            </div>
            <div style="clear:both">&nbsp; </div>
        </div>
    </body>
</html>