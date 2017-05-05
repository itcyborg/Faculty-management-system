/**
 * Created by itcyb on 5/3/2017.
 */
function getPage(url,page,divid){
    $.ajax({
        url:    url,
        data:   {
            'page' :page
        },
        type:   'POST',
        beforeSend:function(){
            $('#'+divid).html("Loading...");
        },
        success:function(data){
            $('#'+divid).html(data);
        }
    });
}
function getPages(url,page,divid,id){
    $.ajax({
        url:    url,
        data:   {
            'page'  :   page,
            'id'    :   id
        },
        type:   'POST',
        beforeSend:function(){
            $('#'+divid).html("Loading...");
        },
        success:function(data){
            $('#'+divid).html(data);
        }
    });
}
