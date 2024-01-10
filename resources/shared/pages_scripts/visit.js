$(window).on("load", window_load);
$(window).on("focus", window_focused);
$(window).on("blur", function () {
    window_unfocused(this, 1);
});

$(window).on("beforeunload", function () {
    window_unfocused(this, 1);
});

setInterval(focus_check, 300 * 1000);

var start = null;
var start_focus_time = new Date();
var last_user_interaction = undefined;

function window_load() {
    var time = event.timeStamp - start;
}

function focus_check() {
    if (start_focus_time != undefined) {
        var curr_time = new Date();
        //Lets just put it for 4.5 minutes                                                                                
        if ((curr_time.getTime() - last_user_interaction.getTime()) > (270 * 1000)) {
            //No interaction in this tab for last 5 minutes. Probably idle.                                               
            window_unfocused();
        }
    }
}

function window_focused(eo) {

    last_user_interaction = new Date();
    if (start_focus_time == undefined) {
        start_focus_time = new Date();
    }
}


function window_unfocused(eo, state) {

    if (start_focus_time != undefined) {
        var stop_focus_time = new Date();
        var total_focus_time = stop_focus_time.getTime() - start_focus_time.getTime();
        start_focus_time = undefined;
        var afid1 = $('#afid').val();
        if ( state == 1) {
            var afid = $('#afid').val();
            var sid = $('#sid').val();
            var cid = $('#cid').val();
            var scid = $('#scid').val();
            var pid = $('#pid').val();
            var puid = $('#puid').val();

            $.ajax({
                type: "POST",
                async: true,
                data: "afid=" + afid + "&ftime=" + total_focus_time + "&sid=" + sid + "&cid=" + cid + "&scid=" + scid + "&pid=" + pid + "&puid=" + puid + "&check=VISIT_OP_CODE" ,
                url: HOST_NAME + "shared/visit/",
                cache: false,
                success: function (result) {
                    console.log(result);
                }
            });
        }

    }
}
