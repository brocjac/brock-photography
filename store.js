$(function(){
    //------------------------------store pop up functions--------------------------------------
    //eztabs
    $('#tab-container').easytabs();
});
//popup dialog for bought items
$('#cartshop').on('click', function () {
    $('#storeContainer').show();
    $('#storeBackdrop').show();
});
$('#x').on('click', function () {
    $('#storeContainer').hide();
    $('#storeBackdrop').hide();
});
$('#storeContainer').hide();
$('#storeBackdrop').hide();