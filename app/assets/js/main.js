$(document).ready(()=>{
    //loader_display(true);
});
$(window).on("load",()=>{
    loader_display(false);
});

function toggleSlide(x){
    $('#slide-'+x).slideToggle(200);
    $('#slide-toggler-'+x+' > i').toggleClass('rot-90');
}
function toggleSlide(x){
    $('#slide-'+x).slideToggle(200);
    $('#slide-toggler-'+x+' > i').toggleClass('rot-90');
}

function setLandingCookie(){
    let landed = getCookie('landed');
    if( landed == "" ){
        // first time
        setCookie('landed',true,30);
    }else{
        $('.skip-button').click();
    }
}

function loader_display(status){
    if( status == true ){
        $("#loader").fadeIn(500);
    }else{
        $("#loader").fadeOut(500);
    }
}

function href(link){
    window.location = link;
}

var menu_tab_timing = 200;
function openMenuTab(){
    $('body').css("overflow","hidden");
    $("#trigger-menu").fadeIn(menu_tab_timing);
    $("#trigger-menu .menu-slide").removeClass('retract');
    $("#trigger-menu .menu-slide").addClass('active');
}
function closeMenuTab(){
    $('body').css("overflow","auto");
    $("#trigger-menu .menu-slide").removeClass('active');
    $("#trigger-menu .menu-slide").addClass('retract');
    $("#trigger-menu").fadeOut(menu_tab_timing);
}

function slider(id,display){
    if( display == true ){
        $("#slide-toggler-"+id).attr("onclick","slider("+id+",false)").removeClass("rot-90");
        $("#slide-toggle-"+id).slideDown(300);
    }else{
        $("#slide-toggler-"+id).attr("onclick","slider("+id+",true)").addClass("rot-90");
        $("#slide-toggle-"+id).slideUp(300);
    }
}

function disableEnter(){
    $('#form button[type=submit]').prop('disabled',true);
}
function enableEnter(){
    $('#form button[type=submit]').prop('disabled',false);
}

function copyToClipboard(x) {
    $('#copy-text').remove();
    $('body').append('<p id="copy-text" class="hide">'+x+'</p>');
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($('#copy-text').text()).select();
    document.execCommand("copy");
    $temp.remove();
}

function delay(time){
    return new Promise((resolve,reject)=>{
        setTimeout(()=>{
            resolve();
        },time);
    });
}

function passwordChanged() {
    var strength = document.getElementById('strength');
    var strongRegex = new RegExp("^(?=.{10,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
    var mediumRegex = new RegExp("^(?=.{8,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var enoughRegex = new RegExp("(?=.{8,}).*", "g");
    var pwd = document.getElementById("password");
    if (pwd.value.length==0) {
    strength.innerHTML = 'Type Password';
    } else if (false == enoughRegex.test(pwd.value)) {
    strength.innerHTML = '8-32 Character.';
    } else if (strongRegex.test(pwd.value)) {
    strength.innerHTML = '<span style="color:green">Strong!</span>';
    } else if (mediumRegex.test(pwd.value)) {
    strength.innerHTML = '<span style="color:orange">Medium!</span>';
    } else {
    strength.innerHTML = '<span style="color:red">Weak!</span>';
    }
}

// Window mobile checking
window.mobilecheck = function() {
    var check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};

//PIN script
var onPinCallback = false;
var pinCallback = ()=>{}
var cancelPin = ()=>{}
var pinEnabled = true;
function enablePin(state){
    if( state == true ){
        pinEnabled = true;
        $('#pin-wrapper').fadeIn(500);
        $('body').css("overflow","hidden");
    }else{
        pinEnabled = false;
        $('#pin-wrapper').hide();
        $('body').css("overflow","auto");
    }
}
function pinCallbackState(state){
    onPinCallback = state;
}
function updateDots(){
    let entered = $("input[name=pin]").val();
    entered = entered.length;
    $(".six-dot > div").removeClass('on');
    for( let i = 1 ; i <= entered ; i++ ){
        $(".six-dot > div:nth-child("+i+")").addClass('on');
    }
    if( entered == 6 ){
        if(onPinCallback==false){
            pinCallback();
        } 
    }
}
function addValue(x){
    let c_value = $("input[name=pin]").val();
    if( $("input[name=pin]").val().length < 6  ){
        $("input[name=pin]").val(c_value+x.toString());
    }
}
function deleteValue(){
    var c_value = $("input[name=pin]").val();
    if( $("input[name=pin]").val().length > 0  ){
        let new_val = c_value.slice(0,(c_value.length-1));
        $("input[name=pin]").val(new_val);
    }
}
function setPinInfo(title,display){
    $(".pin-info").html(title);
    if( display == true ){
        $('.pin-info').css('display','table');
    }else{
        $('.pin-info').css('display','none');
    }
}
function getPinValue(){
    return $("input[name=pin]").val();
}
function resetPinValue(){
    $("input[name=pin]").val("");
    updateDots();
}
function changePinHeader(title="",forgot=true){
    if( title != "" ){
        $("#pin-title").html(title);
    }
    if( forgot == true ){
        $('.forgot-btn').show();
    }else{
        $('.forgot-btn').hide();
    }
}

//currecy auto zero separator
(function($, undefined) {

    "use strict";

    // When ready.
    $(function() {
        
        var $form = $( "#form" );
        var $input = $form.find( "#amount" );

        $input.on( "keyup", function( event ) {
            
            
            // When user select text in the document, also abort.
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }
            
            // When the arrow keys are pressed, abort.
            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            }
            
            
            var $this = $( this );
            
            // Get the value.
            var input = $this.val();
            var cur_value = parseInt(input.replace(/[\.]+/g,"")); //real int value
            $("#real-amount").val(cur_value);
            
            var input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt( input, 10 ) : 0;

                    $this.val( function() {
                        return ( input === 0 ) ? "" : input.toLocaleString( "id-ID" );
                    } );
        } );
    });
})(jQuery);