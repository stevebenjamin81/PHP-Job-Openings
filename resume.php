<?php
/*
Copyright 2019 Steven S Benjamin
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the Software), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, andor sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
if (!isset($_SESSION['user_logged'])) {
    die("not authorized!");
}
$jobs_id = $type = filter_input(INPUT_GET, 'jobs_id');
?><html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="js/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script>
            $(document).ready(function () {

                $(':file').on('change', function () {

                    $("#bar").hide();

                    $("#alert").html('');

                    var file = this.files[0];
                    var fp = file.name.split('.');

                    if (file.size > 200000) {
                        $("#alert").html('<spane style="color:#FF0000">The max upload size is 200kb!</span>');
                    }

                    // Additional security checks in backend
                    if (fp[1] !== 'docx' && fp[1] !== 'doc') {
                        $("#alert").html('<spane style="color:#FF0000">Only MS Word (.doc and .docx) are allowed!</span>');

                        $('#file').each(function () {
                            $(this).after($(this).clone(true)).remove();
                            $(this).val("");
                        });
                    }

                    // Also see .name, .type
                });

                $(':button').on('click', function () {

                    $("#bar").show();
                    $("#form").hide();

                    $.ajax({
                        // Your server script to process the upload
                        url: 'json_response.php?type=upload&jobs_id=<?= $jobs_id ?>',
                        type: 'POST',

                        // Form data
                        data: new FormData($('form')[0]),
                        // You *must* include these options!
                        cache: false,
                        contentType: false,
                        processData: false,
                        // Custom XMLHttpRequest
                        xhr: function () {
                            var myXhr = $.ajaxSettings.xhr();
                            if (myXhr.upload) {
                                // For handling the progress of the upload HTML5
                                myXhr.upload.addEventListener('progress', function (e) {
                                    if (e.lengthComputable) {
                                        $('progress').attr({
                                            value: e.loaded,
                                            max: e.total
                                        });
                                    }
                                }, false);
                            }
                            $("#alert").html('<spane style="color:#008000">Your upload has completed, thank you!</span> <br /><strong>This window will close in 5 seconds.</strong>');
                            setTimeout(
                                    function ()
                                    {
                                        javascript:parent.jQuery.fancybox.close();
                                    }, 5000);
                            return myXhr;
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <div style="text-align:center">
            <h1>Upload Your Resume</h1>
            <p>Use the form to upload a resume file (.doc or .docx)</p>

            <div id="alert"></div>

            <div style="display:none; margin:10px;" id="bar">
                <progress></progress>
            </div>
            <div style="margin:10px;" id="form">      
                <form enctype="multipart/form-data">
                    <input name="file" type="file" id="file" />
                    <input type="button" value="Upload" />
                </form>
            </div>
    </body>
</html>
