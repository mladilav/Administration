$(document).ready(function() {

    $('#pass').blur(function(){
        if(($(this).val().length < 6)&&($(this).val().length!=0)){
            $('.pasw').removeClass('hide');}
        else{
            $('.pasw').addClass('hide');
        }
    });
    $('#rep').blur(function(){
        if(($('#pass').val() != $(this).val())&&($(this).val().length*$('#pass').val().length)!=0){

            $('.repeat').removeClass('hide');}
        else {
            $('.repeat').addClass('hide');
        }
       });
    $('#email').blur(function(){
        if(!isValidEmailAddress($(this).val())){
            $('.email').removeClass('hide');
        }  else {
            $('.email').addClass('hide');
        }
    });



});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};