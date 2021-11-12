function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}



//jQuery(function($) {
$(document).ready(function(){
    $(function(){
        $('#main-slider.carousel').carousel({
            interval: 10000,
            pause: false
        });
    });

    //Ajax contact
    var form = $('.contact-form');
    form.submit(function (evt) {
        $this = $(this);
        $.post('sendmessage.php',{ name: $('input[name=name]').val(), email: $('input[name=email]').val(), message: $('textarea[name=message]').val() }, function(data) {
            $this.prev().text(data.message).fadeIn().delay(10000).fadeOut();
            $this.find('input, textarea').val('');
        },'json');
        evt.preventDefault();
        return false;
    });

    //smooth scroll
    $('.navbar-nav > li').click(function(event) {
        //event.preventDefault();
        var target = $(this).find('>a').prop('hash');
        $('html, body').animate({
            scrollTop: $(target).offset().top
        }, 500);
    });

    //scrollspy
    $('[data-spy="scroll"]').each(function () {
        var $spy = $(this).scrollspy('refresh')
    });
});
