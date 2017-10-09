$(document).ready(function() {
    $("#start").click(function() {
        location.reload();
    });

    var words = ["HELLO", "GOODBYE", "DESTINY", "JOLLY", "PIZZAZZ", "BUZZWIG", "ACTING", "ADJURE", "ADJUST", "SEIZURE"]
    var index = [];
    var misses = 0;
    var hits = 0;
    var my_div = document.getElementById('my_div');
    var word = words[Math.floor(Math.random() * words.length)];

    $("h3").hide();

    switch (word.length) {
        case 4:
            $("#letter5, #letter6, #letter7").hide();
            break;
        case 5:
            $("#letter6, #letter7").hide();
            break;
        case 6:
            $("#letter7").hide();
            break;
        default:
            break;
    }

    $("#A, #B, #C, #D, #E, #F, #G, #H, #I, #J, #K, #L, #M, #N, #O, #P, #Q, #R, #S, #T, #U, #V, #W, #X, #Y, #Z").click(function() {
        var fired_button = $(this).text();
        for (var i = 0; i < word.length; i++) {
            var res = word.charAt(i);
            if (fired_button == res) {
                index.push(i);
            	hits++;
            }
        }
        for (var j = 0; j <= index.length; j++) {
            $("#letter" + (index[j] + 1)).text(fired_button);
        }
        if (index.length == 0) {
            misses++;
            $("#miss" + misses).show();
        }
        if ($('#miss7').is(':visible')) {
            $("#lose_message").html('You lost. The word was <b>' + word + '</b>. Select New Game to play again.');
            $("#lose_message").show();
        }

        if (hits == word.length){
            $("#lose_message").html('<b> You WON!. Select New Game to play again. </b>');
            $("#lose_message").show();
        }
        $(this).css('visibility', 'hidden')
        index = [];
        $("#misscount").text(misses);
    });
});