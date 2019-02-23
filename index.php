<?
/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
php
session_start();?><html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/jquery.fancybox.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">

    </head>
    <body>
        <h1>Employment Opportunities</h1>
        <div id="nav"></div>
        <div id="container">
            <div id="leftpane">
                <h2>Department</h2>
            </div>
            <div id="rightpane">
                <h2>Job Openings</h2>
            </div>
            <div style="clear:both">&nbsp; </div>
        </div>

        <script>
            $(document).ready(function () {
<?php
if (isset($_SESSION['name'])) {
    echo '$("#nav").html("Welcome ' . $_SESSION['email'] . ',' .
    ' you can <span id=\"logout\">[ logout here ]</span>");' . "\n" .
    "$('#logout').css('color', '#008000');\n" .
    "$('#logout').css('font-weight', 'bold');\n" .
    "$('#logout').css( 'cursor', 'pointer' );\n";
}
?>

                $(document).on("click", "#logout", function () {
                    $.getJSON("json_response.php?type=logout", function () {
                        $("#nav").html("");
                    });
                });

                //populate left pane
                $.getJSON("json_response.php?type=categories", function (data) {
                    var items = [];
                    $.each(data.payload, function () {
                        $.each(this, function (key, val) {
                            var str = '';
                            if (key === 'id') {
                                str += "<li id='" + val + "'>";
                            }
                            if (key === 'name') {
                                str += val + "</li>";
                            }
                            items.push(str);
                        });
                    });
                    $("<ul/>", {
                        "id": "catUL",
                        html: items.join("")
                    }).appendTo("#leftpane");
                });

                // on left pane category click populate left pane
                // must us $(document).on because the li is dynamically added
                $(document).on("click", "#leftpane > ul > li", function () {

                    //avoid duplicates
                    $("#rightpane ul").empty();

                    $.getJSON("json_response.php?type=jobs&category_id=" + $(this).attr("id"), function (data) {
                        var items = [];
                        var job = '';
                        var title = '';
                        $.each(data.payload, function () {
                            $.each(this, function (key, val) {
                                var str = '';

                                if (key === 'id') {
                                    job = val;
                                    str += '<li><a data-fancybox data-src="#job' + val + '" href="javascript:;">';
                                }
                                if (key === 'name') {
                                    title = val;
                                    str += val + "</a>";
                                }
                                if (key === 'short_description') {
                                    str += val;
                                }

                                //div overlay for full job description
                                if (key === 'description') {
                                    str += '</a><div style="display: none;" id="job' + job + '">';
                                    str += '<h1>' + title + '</h1><br /><br />';
                                    str += val.replace(/(?:\r\n|\r|\n)/g, '<br />');
                                    str += '<div id="jobActions"><button type="button" data-fancybox data-type="iframe" data-src="apply.php?type=job&jobs_id=';
                                    str += job + '" href="javascript:;">Apply Now!</button>';
                                    str += '</div></div></li>';

                                }

                                items.push(str);
                            });
                        });
                        $("<ul/>", {
                            "id": "jobsUL",
                            html: items.join("")
                        }).appendTo("#rightpane");
                    });

                });

            });
        </script>
    </body>
</html>
