/**
 * Created by JoshC on 3/5/2017.
 */

var x =100,y=100,w=100,h=100;
$('#image_to_crop').Jcrop({
    setSelect: [ x,y,w,h ],
    aspectRatio: 1,
    bgColor: 'red',
    onSelect: updateCoords
});

function updateCoords(c){

    jQuery('#cropx').val(c.x);
    jQuery('#cropy').val(c.y);
    jQuery('#cropw').val(c.w);
    jQuery('#croph').val(c.h);

}
$('#image_to_crop').on('cropmove cropend',function(e,s,c){
    $('#cropx').val(c.x);
    $('#cropy').val(c.y);
    $('#cropw').val(c.w);
    $('#croph').val(c.h);
});
$('#image_crop_form').on('change','[type=text]',function(e){

    $('#image_to_crop').Jcrop('api').setSelect([
        parseInt($('#cropx').val()),
        parseInt($('#cropy').val()),
        parseInt($('#cropw').val()),
        parseInt($('#croph').val())
    ]);

});

function checkCoords()
{
    if (parseInt(jQuery('#cropw').val())>0) return true;
    alert('Please select a crop region then press submit.');
    return false;
};

$('#image_to_crop').on('cropstart cropmove cropend',function(e,s,c){

    console.log(e,s,c);
    // @todo: do something useful with c
    // { x: 10, y: 10, x2: 30, y2: 30, w: 20, h: 20 }
    // c.x, c.y, c.w, c.h, ...
    // or access s.selectionApiMethod() or s.core.apiMethod() etc
    // compare event type with e.type (e.g. in if conditional, switch block)

});
/*
var jcrop_api = $('#image_to_crop').Jcrop('api');

jcrop_api.ui.selection.element.on('cropmove',function(e,s,c){

});*/