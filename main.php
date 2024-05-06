<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div id="body_news">

    </div>
</body>

<script src="/jquery-3.3.1.min.js"></script>
<script>
    $("document").ready(function() {
        $.ajax({
            url: "get_news.php",
            type: "GET",
            data: ({
                str: -1
            }),
            dataType: "html",
            success: funcSuccess
        })
        setInterval(checkReplyes, 10000)
    })

    function set_update(data){
        data = $.parseJSON(data)
        for (let index = 0; index < data.length; index++) {
            if (data[index] != "") {
                let v = $("#" + (index + 1).toString()).children(".PostContent").children(".replies")
                v.children(":first-child").text(data[index][1])
                v.children(":last-child").text(data[index][0])
            } 
        }
    }

    function checkReplyes(){
        var mas = ""
        $(".replies").children(":last-child").toArray().forEach(element => {
            mas += (element.textContent + ";")
        }); 
        $.ajax({
            url: "check_update.php",
            type: "GET",
            data: ({
                r: mas
            }),
            dataType: "html",
            success: set_update
        })
    }

    function funcSuccess(data) {
        $("#body_news").append(data);
    }

    function foo2(f){
        if (f.previousElementSibling.value == "") return;
        var options = {
            month: 'long',
            day: 'numeric',
            timezone: 'UTC',
            hour: 'numeric',
            minute: 'numeric'
        };
        $.ajax({
            url: "send_reply.php",
            type: "POST",
            data: ({
                reply: f.previousElementSibling.value,
                time: new Date().toLocaleString("ru", options),
                i_new: f.parentNode.parentNode.parentNode.id
            }),
            dataType: "html",
            success: funcSuccess
        })
        f.previousElementSibling.value = ""
    }

    function viewReplys(data){
        $("#body_news").hide();
        $("body").append(data);
    }

    function foo3(f){
        $.ajax({
            url: "get_replys.php",
            type: "GET",
            data: ({
                str: f.parentNode.parentNode.parentNode.id
            }),
            dataType: "html",
            success: viewReplys
        })
    }

    function foo4(){
        $("#body_news").show();
        $(".div_replys").remove();
    }
    
</script>


</html>