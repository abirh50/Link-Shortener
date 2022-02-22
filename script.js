let domain = "https://venus.cs.qc.cuny.edu/~haab5466/cs355/linkShortener.php/?id=";

// "Convert" button
$(document).ready(function(){
    $('#shorten').click(function(e) {
        let alias = document.getElementById("aliastext").value;
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'link.php',
            data: {ltext: $('#longtext').val(), shortUrl: (domain + shorten(alias))},
            success: function(data)
            {
                $("#result").html(data);
            }
        });
    });
});

// "User History" button
$(document).ready(function(){
    $('#history').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'history.php',
            success: function(data)
            {
                $("#result").html(data);
            }
        });
    });
});


// function for shortening link
function shorten(randString) {
    let n = 8;

    while(randString.length < n){
        // r is 0 to 127
        let r = Math.floor(Math.random() * 128);

        // 0 to 9
        if(r >= 48 && r <= 57){
            randString += String.fromCharCode(r);
        }
        // A to Z
        else if(r >= 65 && r <= 90){
            randString += String.fromCharCode(r);
        }
        // a to z
        else if(r >= 97 && r <= 122){
            randString += String.fromCharCode(r);
        }
    }


    return randString;
}

// function for clearing textbox
function clearAll() {
    document.getElementById("longtext").value = "";
    $('#result').empty();
}