<script type="text/javascript">
    $(document).ready(function()
    {
        var start = /@/ig; // @ Match
        var word = /@(\w+)/ig; //@abc Match

        $("#contentbox").keyup(function()
        {
            var content = $(this).text(); //Content Box Data
            var go = content.match(start); //Content Matching @
            var name = content.match(word); //Content Matching @abc
            var dataString = 'searchword=' + name;
//If @ available
            if (go.length > 0)
            {
                $("#msgbox").slideDown('show');
                $("#display").slideUp('show');
                $("#msgbox").html("Type the name of someone or something...");
//if @abc avalable
                if (name.length > 0)
                {
                    $.ajax({
                        type: "POST",
                        url: "herbal/showplant/show", // Database name search 
                        data: dataString,
                        cache: false,
                        success: function(data)
                        {
                            $("#msgbox").hide();
                            $("#display").html(data).show();
                        }
                    });
                }
            }
            return false();
        });

//Adding result name to content box.
        $(".addname").click(function()
        {
            var username = $(this).attr('title');
            var old = $("#contentbox").html();
            var content = old.replace(word, " "); //replacing @abc to (" ") space
            $("#contentbox").html(content);
            var E = "<a class='red' contenteditable='false' href='#' >" + username + "</a>";
            $("#contentbox").append(E);
            $("#display").hide();
            $("#msgbox").hide();
        });
    });
</script>

<div id="container">
    <div id="contentbox" contenteditable="true">
    </div>
    <div id='display'>
    </div>
    <div id="msgbox">
    </div>
</div>
