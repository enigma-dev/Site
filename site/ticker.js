$(document).ready(function() {
        
        marquee = $("#enigmaTicker > marquee").marquee()
	marquee.mouseover(function () {
                  $(this).trigger('stop');
                }).mouseout(function () {
                  $(this).trigger('start');
                }).bind("end",function() {
                        marquee = this;
                        })
                setInterval(function() {
                        $.get("/site/latestCommit.php",function(d) {
                                if($("#commitTicker").html() == d) { } else {
				$("#commitTicker").fadeOut("fast",function() { 
	                                $("#commitTicker").html(d).fadeIn("fast");
				})
                        }
                        })
                },60*1000);
        $("#enigmaTicker").css({marginLeft: $("#menu").width(), marginRight: $("#userinfo").width()});

})
