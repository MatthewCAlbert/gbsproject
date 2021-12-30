var enter_enabled = false; //enabling enter to submit form preventing auto submit after scanning

//document on ready
$(document).ready(function() {
    if( $('#auth-enter').hasClass('not-auth') ){
        disableEnter();
    }
});
//window on load
$(window).on('load',function(){
    $('#loader').hide();
});

function authorizeEnter(){
    if( $('#auth-enter').hasClass('not-auth') ){
        $('#auth-enter').removeClass('btn-danger');
        $('#auth-enter').removeClass('not-auth');
        $('#auth-enter').addClass('btn-success');
        $('#auth-enter').addClass('auth');
        $('#auth-enter').html('De-Authorize');
        enableEnter();
    }else{
        $('#auth-enter').removeClass('btn-success');
        $('#auth-enter').removeClass('auth');
        $('#auth-enter').addClass('btn-danger');
        $('#auth-enter').addClass('not-auth');
        $('#auth-enter').html('Authorize');
        disableEnter();
    }
}

function disableEnter(){
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
        });
}
function enableEnter(){
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return true;
        }
        });
}


function href(x){
    window.location.href= x;
}

//FORMS
function valueEnabler(){
    if ( $("input[name=val-enb]").prop("checked") == true ){
        $("input[name=val-min]").prop('disabled', false);
        $("input[name=val-max]").prop('disabled', false);
        setCookie('value-limit','true',30);
    }else{
        $("input[name=val-min]").prop('disabled', true);
        $("input[name=val-max]").prop('disabled', true);
        setCookie('value-limit','false',30);
    }
}
function updateRangeFilter(){
    setCookie('val-min',$("input[name=val-min]").val(),30);
    setCookie('val-max',$("input[name=val-max]").val(),30);
}
function changeRangeFilter(x,y){
    $("input[name=val-min]").val(x);
    $("input[name=val-max]").val(y);
}

function switchFilterOption(){
    setCookie('filter1',$("#filter1").val(),30);
    setCookie('filter2',$("#filter2").val(),30);
    setCookie('type-filter',$("#type-filter").val(),30);
}

function applyFilterOption(){
    let filter1 = getCookie('filter1');
    let filter2 = getCookie('filter2');
    let type_filter = getCookie('type-filter');

    $('#filter1 option[value='+filter1+']').prop('selected',true);
    $('#filter2 option[value='+filter2+']').prop('selected',true);
    $('#type-filter option[value='+type_filter+']').prop('selected',true);
}

function changeEnterEnabled(){
    setCookie('enter-enabled',$("input[name=enter]:checked").val(),30);
    if( $("input[name=enter]:checked").val() == 'false' ){
        $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
        });
    }
}

function checkPassword(){
    let password = $('input[name=password]').val();
    let re_password = $('input[name=re-password]').val();
    if( password != re_password ){
        $('form .warn').remove();
        $('input[name=password]').after('<span class="text-danger warn">Mismatch!</span>');
        $('input[name=re-password]').after('<span class="text-danger warn">Mismatch!</span>');
    }else{
        $('form .warn').remove();
    }
}

//maintenance section
function changeAction(){
    $('#modify-database').attr('action',''+$('#db-edit-select').val()+'.php'); 
}

//edit section
function toggleEditForm(x){
    switch(x){
        case 'reset' :
        if(passreset == false){
            passreset = true;
            $("input[name=reset-password").prop('checked',true);
            $("#pass-reset").show();
            $("#confirmModal .reset").show();
        }else{
            passreset = false;
            $("input[name=reset-password").prop('checked',false);
            $("#pass-reset").hide();
            $("#confirmModal .reset").hide();
        }
        break;
        case 'rfid' :
        if(rfid_change == false){
            rfid_change = true;
            $("input[name=rfid-change").prop('checked',true);
            $("#new-rfid").show();
            $("#confirmModal .rfid").show();
        }else{
            rfid_change = false;
            $("input[name=rfid-change").prop('checked',false);
            $("#new-rfid").hide();
            $("#confirmModal .rfid").hide();
        }
        break;
        case 'delete' :
        if(deleteaccount == false){
            deleteaccount = true;
            $("input[name=delete-account").prop('checked',true);
            $("#del-stat").show();
            $("#confirmModal .delete").show();
        }else{
            deleteaccount = false;
            $("input[name=delete-account").prop('checked',false);
            $("#del-stat").hide();
            $("#confirmModal .delete").hide();
        }
        break;
        case 'banning' :
        if(banning == false){
            banning = true;
            if( banned == true ){
            $("input[name=switch-status").prop('checked',false);
            }else{
            $("input[name=switch-status").prop('checked',true);
            }
            $("#ban-btn").html('Unban').removeClass('btn-danger').addClass('btn-success');
            $("#confirmModal .banning").show();
        }else{
            banning = false;
            if( banned == true ){
            $("input[name=switch-status").prop('checked',true);
            }else{
            $("input[name=switch-status").prop('checked',false);
            }
            $("#ban-btn").html('Ban').removeClass('btn-success').addClass('btn-danger');
            $("#confirmModal .banning").hide();
        }
        break;
        case 'pinreset' :
        if(pinreset == false){
            pinreset = true;
            $("input[name=reset-pin").prop('checked',true);
            $("#pin-reset").show();
            $("#confirmModal .pin").show();
        }else{
            pinreset = false;
            $("input[name=reset-pin").prop('checked',false);
            $("#pin-reset").hide();
            $("#confirmModal .pin").hide();
        }
        break;
    }
}

function showNotification(from, align, message){
    $.notify({
        icon: "add_alert",
        message: message
    },{
        type: 'primary',
        timer: 4000,
        placement: {
            from: from,
            align: align
        }
    });
  }

//currency live input separator
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
            
            var input = input.replace(/[\D\s\._\-]+/g, "");
                    input = input ? parseInt( input, 10 ) : 0;

                    $this.val( function() {
                        return ( input === 0 ) ? "" : input.toLocaleString( "id-ID" );
                    } );
        } );
    });
})(jQuery);