$(document).ready(function(){
    $("#shortform").submit(function(){
        var jUrl = $("#id_entrybar").val();
        var dataString = 'postUrl='+ jUrl;
        if(jUrl=='') {
            alert("Please enter a URL");
        } else {
            $.ajax({
                type: "POST",
                url: "su-submit.php",
                data: dataString,
                dataType: "text",
                cache: false
            })
            .done(function(resp_txt) {
                // use for debugging
                //if ( console && console.log ) {
                    //console.log( "Sample of data:", resp_txt );
                //}
                if (resp_txt=="INSERT_ERROR") {
                    $('#resultcontainer').css({visibility: "visible", display: "block"});
                    $('#longurlpart').html("Database error.  Please try again, or figure out what's wrong.");
                    $('#copylink').css({display: "none"});
                } else {
                    var trimUrl = jUrl.replace(/(^\w+:|^)\/\//, '');
                    var finUrl = trimUrl;
                    if ( trimUrl.length > 30 ) {
                        finUrl = trimUrl.substring(0,29) + "...";
                    }
                    $('#resultcontainer').css({visibility: "visible", display: "block"});
                    $('#longurlpart').html(finUrl);
                    $('#shorturl').html("<a target=\"_blank\" href=\"http://[your site]/" + resp_txt + "\">[your site]/" + resp_txt + "</a>");
                    $('#shorturl').attr("shortlink","http://[your site]/" + resp_txt);
                }
            })
            .fail(function(jqxhr, textStatus, errorThrown) {
                $('#resultcontainer').css({visibility: "visible", display: "block"});
                $('#longurlpart').html("Error: " + errorThrown + ".  Please try again, or figure out what's wrong.");
                $('#copylink').css({display: "none"});
            });
        }
        return false;
    });
});

function copyShort() {
    // use this method to work with both http and https
    // https://stackoverflow.com/questions/51805395/navigator-clipboard-is-undefined
    
    var textToCopy = document.getElementById("shorturl").getAttribute("shortlink");

    // navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        // navigator clipboard api method'
        return navigator.clipboard.writeText(textToCopy);
    } else {
        // text area method
        let textArea = document.createElement("textarea");
        textArea.value = textToCopy;
        // make the textarea out of viewport
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        return new Promise((res, rej) => {
            // here the magic happens
            document.execCommand('copy') ? res() : rej();
            textArea.remove();
        });
    }
}
