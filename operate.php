<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0049)http://lzjstudy.natapp1.cc/javascript_simple.html -->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>我的树莓派监控</title>
    <script src="jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css" />

  
    <script type="text/javascript">
        $(document).ready(function(){
            $("#up").bind("click",function(){
                use_python("up");
            });
            $("#down").bind("click",function(){
                use_python("down");
            });
            $("#left").bind("click",function(){
                use_python("left");
            });
            $("#right").bind("click",function(){
                use_python("right");
            });
            $("#reset").bind("click",function(){
                use_python("reset");
            });
        });
        //     $("#up").mousedown(function(){
        //         Move('up');
        //     });
        //
        //     $("#down").mousedown(function(){
        //         Move('down');
        //     });
        //
        //     $("#left").mousedown(function(){
        //         Move('left');
        //
        //     });
        //     $("#right").mousedown(function () {
        //         Move('right');
        //     });
        //     $("#reset").mousedown(function () {
        //         Move('reset');
        //     });
        //
        //
        //     $("#up").mouseup(function(){
        //         MouseUp ();
        //     });
        //
        //     $("#down").mouseup(function(){
        //         MouseUp ();
        //     });
        //
        //     $("#left").mouseup(function(){
        //         MouseUp ();
        //
        //     });
        //     $("#right").mouseup(function () {
        //         MouseUp ();
        //     });
        //     $("#reset").mouseup(function () {
        //         MouseUp ();
        //     });
        //
        //
        //
        //

        //     var timer=null;
        //     var MoveTime=500;//间隔时间，可调整
        //
        //     function Move (f)
        //     {
        //         clearInterval(timer);
        //         timer=setInterval(function (){
        //
        //             switch (f)
        //             {
        //                 case 'left' :
        //                     use_python(f);
        //                     break;
        //
        //                 case 'right' :
        //                     use_python(f);;
        //                     break;
        //
        //                 case 'up' :
        //                     use_python(f);
        //                     break;
        //
        //                 case 'down' :
        //                     use_python(f);
        //                     break;
        //                 case 'reset':
        //                     use_python(f);
        //                     break;
        //             }
        //
        //         },MoveTime)
        //     }
        //
        //
        //     function MouseUp ()
        //     {
        //         clearInterval(timer);
        //         timer=null;
        //     }

            function use_python(f) {

                $.post("get_args.php",
                    {
                        direction:f
                    },
                    function(data){
                        if(data==-1)
                        {
                           alert("参数错误");//没有POST
                        }
                        else
                        {
                            console.log(data);
                        }

                    });
            }

    </script>
    <script type="text/javascript">

        /* Copyright (C) 2007 Richard Atterer, richard©atterer.net
           This program is free software; you can redistribute it and/or modify it
           under the terms of the GNU General Public License, version 2. See the file
           COPYING for details. */

        var imageNr = 0; // Serial number of current image
        var finished = new Array(); // References to img objects which have finished downloading
        var paused = false;
        function createImageLayer() {
            var img = new Image();
            img.style.position = "absolute";
            img.style.zIndex = -1;
            img.onload = imageOnload;
            img.onclick = imageOnclick;
            img.src = "http://lzjstudy.natapp1.cc?action=snapshot&n=" + (++imageNr);
            var webcam = document.getElementById("webcam");
            if (imageNr>100)
            {
                imageNr=0;
            }
            webcam.insertBefore(img, webcam.firstChild);
        }

        // Two layers are always present (except at the very beginning), to avoid flicker
        function imageOnload() {
            this.style.zIndex = imageNr; // Image finished, bring to front!
            while (1 < finished.length) {
                var del = finished.shift(); // Delete old image(s) from document
                del.parentNode.removeChild(del);
            }
            finished.push(this);
            if (!paused) createImageLayer();
        }

        function imageOnclick() { // Clicking on the image will pause the stream
            paused = !paused;
            if (!paused) createImageLayer();
        }

    </script>
</head>

<body onload="createImageLayer();">

<div class="video" id="webcam"></div>


<div class="change_camera_direction">
    <div class="camera_title">摄像头方向控制</div>
    <div class="direction_content">
        <div class="direction_div top_direction">
            <input type="button" class="camera_img_up" id="up" value="↑" />
        </div>
        <div class="direction_div left_direction">
            <input type="button" class="camera_img_left" id="left" value="←" />
        </div>
        <div class="direction_div bottom_direction">
            <input type="button" class="camera_img_bottom" id="down" value="↓" />
        </div>
        <div class="direction_div right_direction">
            <input type="button" class="camera_img_right" id="right" value="→" />
        </div>
        <div class="direction_div reset_direction">
            <input type="button" class="camera_img_reset" id="reset" value="重置" />
        </div>
    </div>
</div>


</body></html>
