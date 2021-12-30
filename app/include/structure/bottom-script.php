<script>
var myLazyLoad = new LazyLoad({
    elements_selector: ".lazy"
});
Waves.init();
Waves.attach('.btn-waves', ['waves-button', 'waves-float']);
$(document).ready(function(){
    var _originalSize = $(window).width() + $(window).height()
    $(window).resize(function(){ //fix nav issue when opening mobile keyboard.
        if( window.mobilecheck() == true ){
            if($(window).width() + $(window).height() != _originalSize){
            $("nav").css("position","relative");  
            }else{
            $("nav").css("position","fixed");  
            }
        }
    });
});
</script>
<noscript>
    Please enable your javascript.
</noscript>