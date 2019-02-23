<?php
/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
require 'secure.php';
$jobs_id = filter_input(INPUT_GET, 'jobs_id');
$categories_id = filter_input(INPUT_GET, 'categories_id');

if ($jobs_id != '') {
    $id = 'job_id=' . $jobs_id;
    $type = "job";
} elseif ($categories_id != '') {
    $id = 'category_id=' . $categories_id;
    $type = "category";
}
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
        <h2 style="text-align:center"> Editor </h2>
        <div id="serverResponse" style="color:#008000; text-align:center; font-weight:bold"></div>
        <div id="editor"></div>
        <script type="text/javascript">
            $(document).ready(function () {
                $.getJSON("../json_response.php?type=<?= $type ?>&<?= $id ?>", function (data) {
                    var str = '';
<?php if ($type == 'job') { ?>
                        // lets get the category names and ids
                        $.getJSON("../json_response.php?type=categories", function (data2) {
                            var str = '<select id="category">';
                            $.each(data2.payload, function () {

                                $.each(this, function (key, val) {
                                    //alert("yes");
                                    if (key === 'id') {
                                        if (val === data.payload[0].category) {
                                            str += '<option value="' + val + '" SELECTED>';
                                        } else {
                                            str += '<option value="' + val + '">';
                                        }
                                    }
                                    if (key === 'name') {
                                        str += val + '</option>';
                                    }
                                });
                            });
                            str += '</select>';
                            $("#editTable").prepend('<tr><td>Category:</td><td>' + str + '</td></tr>');
                            //alert(selBox);
                        });
                        //end
<?php } ?>
                    str += '<table id="editTable" style="margin:0px auto;"><tr><td style="text-transform: capitalize;margin:4px"><br />';
                    str += 'Name:</td><td><input type="text" id="name" value="' + data.payload[0].name + '" style="width:500px;">';
                    str += '</td></tr>';
                    str += '<tr><td>Description:</td><td><textarea style="width:500px;height:120px" id="description">' + data.payload[0].description + '</textarea></td></tr>';
                    str += '<tr><td><input type="hidden" value="' + data.payload[0].id + '" id="id"></td><td align="right"><button id="button">Save Changes</button></td></tr>';
                    $("#editor").append(str + '</table>');
                });
                // update the data on button click
                $(document).on("click", "#button", function () {

                    if (window.confirm("Are you sure?")) {

                        var id = $("#id").val();
                        var name = $("#name").val();
                        var description = $("#description").val();
                        var category = $("#category").val();
                        //alert(id + "\n" + name + "\n" + description);

                        $.post("../json_response.php?type=up<?= $type ?>",
                                {
                                    id: id,
                                    name: name,
                                    description: description,
                                    category: category
                                },
                                function (data) {
                                    if (data.payload === 1) {
                                        $("#serverResponse").html("SYSTEM MSG: You have successfully updated the data!");
                                    } else
                                        $("#serverResponse").html("SYSTEM MSG: Something went wrong while updating the data!");
                                });
                        setTimeout(
                                function ()
                                {
                                    $("#serverResponse").html("");
                                }, 2000);
                    }
                });

            });
        </script>
    </body>
</html>

