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


    $('.change-table').jScrollPane();



        $( "#sortable" ).sortable({
        axis: 'y',
            update : function (event, ui) {
        var data = $( "#sortable").sortable('serialize');
        var projectId = ui.item.attr('data-project');
        var categoryId = ui.item.attr('data-category');
        var data2 = data+"&projectId="+projectId+"&categoryId="+categoryId;
                $.ajax({
                    type: "POST",
                    url: "/ajax/sort",
                    data: data2,
                    success: function(json){
                        GetBugs(json);
                    }
                });
    }
    });

    $(document).on('click','#addbugs',function(){

        var text = $("#text").val();
        var projectId = $( "#sortable").attr('data-project');
        var categoryId = $( "#sortable").attr('data-category');
        $.ajax({
            type: "POST",
            url: "/ajax/addbugs",
            data: "text="+text+"&projectId="+projectId+"&categoryId="+categoryId,
            success: function(json){
            GetBugs(json);
        }
        });
        $('.alert-block').hide();
    });

    $(document).on('click', '.bugs-status',function(){
        if($(this).parents("li").hasClass("active")){
            $(this).parents("li").removeClass("active");
            var status = '0';
        } else {
            $(this).parents("li").addClass("active");
            var status = '1';
        }

        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: "/ajax/bugs",
            data: "id="+id+"&status="+status,
            success: function(html) {}
        });
    });

    $(document).on('click','#add-category',function(){

        var name = $("#category-text").val();
        var projectId = $("#category-text").attr('data-project');

        $.ajax({
            type: "POST",
            url: "/ajax/addcategory",
            data: "name="+name+"&projectId="+projectId,
            success: function(json){
                GetCategory(json);
            }
        });
        $('.alert-block').hide();
    });


});

function GetBugs(json) {

    var array = jQuery.parseJSON( json );
    var ul = document.getElementById('sortable');
    ul.innerHTML = '';
    for(var i = 0; i < array.length; i++){

        var li = document.createElement('li');
        var a = document.createElement('a');
        var input = document.createElement('input');
        var label = document.createElement('label');

        li.setAttribute('id','number-'+array[i].number);
        li.setAttribute('data-project',array[i].projectId);
        li.setAttribute('data-category',array[i].categoryId);

        if(array[i].status == 1){
            li.setAttribute('class','active');
            input.setAttribute('checked','true');
        }
        a.innerHTML = array[i].text;
        input.setAttribute('type','checkbox');
        input.setAttribute('id','check-'+array[i].id);
        input.setAttribute('data-id',array[i].id);
        input.setAttribute('class','bugs-status');

        label.setAttribute('for','check-'+array[i].id)
        a.appendChild(input);
        a.appendChild(label);
        li.appendChild(a);
        ul.appendChild(li);
    }
}



function GetCategory(json) {

    var array = jQuery.parseJSON( json );
    var ul = document.getElementById('categories');
    ul.innerHTML = '';
    for(var i = 0; i < array.length; i++){

        var li = document.createElement('li');
        var a = document.createElement('a');
        li.setAttribute('data-project',array[i].projectId);

        a.setAttribute('href',"/bugs/?projectId="+array[i].projectId+"&categoryId="+array[i].id)
        a.innerHTML = array[i].name;

        li.appendChild(a);
        ul.appendChild(li);
    }
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};