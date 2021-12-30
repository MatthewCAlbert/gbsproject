<div id="pin-wrapper">
    <div class="d-flex justify-content-center">
        <div class="align-self-center">
            <div>
                <h4 id="pin-title">Enter Your Security PIN</h4>
                <h6 class="pin-info"></h6>
                <h6 onclick="href('../cs');" class="forgot-btn btn">Forgot?</h6>
            </div>
            <div class="six-dot">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <br>
            <div class="pin-key-wrapper">
                <div class="key one" onclick="addValue(1);">1</div>
                <div class="key two" onclick="addValue(2);">2</div>
                <div class="key three" onclick="addValue(3);">3</div>
                <div class="key four" onclick="addValue(4);">4</div>
                <div class="key five" onclick="addValue(5);">5</div>
                <div class="key six" onclick="addValue(6);">6</div>
                <div class="key seven" onclick="addValue(7);">7</div>
                <div class="key eight" onclick="addValue(8);">8</div>
                <div class="key nine" onclick="addValue(9);">9</div>
                <div class="key cancel" onclick="cancelPin();"><i class="fas fa-times"></i></div>
                <div class="key zero" onclick="addValue(0);">0</div>
                <div class="key backspace" onclick="deleteValue();"><i class="fas fa-backspace"></i></div>
            </div>
            <form action="#" method="post" class="hide">
                <input type="text" maxlength="6" val="" name="pin" onkeyup="updateDots()" />
            </form>
        </div>
    </div>
</div>
<script>
    //keypress
    $('body').css("overflow","hidden");
    $("#pin-wrapper .pin-key-wrapper > .key").on("click",function(){
        updateDots();
        $(this).addClass('pressed');
        setTimeout(() => {
            $(this).removeClass('pressed');
        }, 100);
    });
    $(window).keydown(function(e){
        if( pinEnabled == true ){
        if(e.keyCode == 96 || e.keyCode == 48) { //num 0
            addValue(0);
        }
        if(e.keyCode == 97 || e.keyCode == 49) { //num 1
            addValue(1);
        }
        if(e.keyCode == 98 || e.keyCode == 50) { //num 2
            addValue(2);
        }
        if(e.keyCode == 99 || e.keyCode == 51) { //num 3
            addValue(3);
        }
        if(e.keyCode == 100 || e.keyCode == 52) { //num 4
            addValue(4);
        }
        if(e.keyCode == 101 || e.keyCode == 53) { //num 5
            addValue(5);
        }
        if(e.keyCode == 102 || e.keyCode == 54) { //num 6
            addValue(6);
        }
        if(e.keyCode == 103 || e.keyCode == 55) { //num 7
            addValue(7);
        }
        if(e.keyCode == 104 || e.keyCode == 56) { //num 8
            addValue(8);
        }
        if(e.keyCode == 105 || e.keyCode == 57) { //num 9
            addValue(9);
        }
        if(e.keyCode == 8 || e.keyCode == 46) { //backspace or delete
            deleteValue();
        }
        if(e.keyCode == 27) { //esc
            cancelPin();
        }
        updateDots();
        }
    });
</script>