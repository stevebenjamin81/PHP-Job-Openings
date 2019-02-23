<?php
/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

require 'secure.php';
$jobs_id = filter_input(INPUT_GET, 'jobs_id');
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
            $(document).ready(function () {
                $.getJSON("../json_response.php?type=applicants&jobs_id=" + <?php echo $jobs_id; ?>, function (data) {
                    var jName = '';
                    $.each(data.payload, function () {
                        var rId = '', rUrl = '', uId = '', uName = '', uEmail = '', rDate = '';
                        $.each(this, function (key, val) {

                            switch (key) {
                                case 'id':
                                    rId = val;
                                    break;
                                case 'resume':
                                    rUrl = val;
                                    break;
                                case 'users_id':
                                    uId = val;
                                    break;
                                case 'name':
                                    uName = val;
                                    break;
                                case 'email':
                                    uEmail = val;
                                    break;
                                case 'date':
                                    rDate = val;
                                    break;
                                case 'jName':
                                    jName = val;
                                    break;
                            }

                        });
                        var str = '<tr>';
                        str += '<td style="border: 1px solid #ccc; padding: 15px;">' + uName + '</td>';
                        str += '<td style="border: 1px solid #ccc; padding: 15px;"><a href="mailto:' + uEmail + '">' + uEmail + '</a></td>';
                        str += '<td style="border: 1px solid #ccc; padding: 15px;"><a href="..' + rUrl + '">Download .doc/.docx</a></td>';
                        str += '<td style="border: 1px solid #ccc; padding: 15px;">' + rDate + '</td>';
                        str += '</tr>';
                        $("#apps").append(str);
                    });
                    $("#appHead").html(jName + " Applicants");
                });
            });

        </script>

        <div id="appDiv" style="  background:#34495E; 
             color:#fff; 
             margin:0px; 
             padding:14px;
             border: 1px solid #ccc; ">
            <h1 id="appHead" style="text-transform:capitalize;">Applicants</h1>
        </div>

        <table id="apps" style="border-collapse: collapse; 
               width:100%; 
               margin-top:30px">
            <tr>
                <th align="left">Name</th>
                <th align="left">Email</th>
                <th align="left">Resume</th>
                <th align="left">Date</th>
            </tr>
        </table>

    </body>
</html>