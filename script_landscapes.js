$(function(){
    //-----------------------------cart number-------------------------------
    var thePhotoName = $(":input[name='photo']");
    $("input[name='photo']").change(function () {
        var checkCheckedBoxes = thePhotoName.filter(':checked').length; //converts the checked checkboxes into numbers
        // display the amount
        if (checkCheckedBoxes === 0){
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 1){
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_01.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 2) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_02.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 3) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_03.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 4) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_04.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 5) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_05.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 6) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_06.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 7) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_07.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 8) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_08.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 9) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_09.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes === 10) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_10.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        } else if (checkCheckedBoxes >= 11) {
            $('#illustrationOfCart').html('<img src="illustrations/shopping_cart_10_plus.svg" alt="Shopping Cart. " id="shoppingCartNumber" width="30px">');
        }
    });

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


window.onload = function () {
    var product = document.getElementById("productCat");
    var productBackdrop = document.getElementById("storeBackdrop");
    product.style.display = "none";
    productBackdrop.style.display = "none";
}
function storePopUp() {
    event.preventDefault();
    var product = document.getElementById("productCat");
    var productBackdrop = document.getElementById("storeBackdrop");
    if (product.style.display === "none") {
        product.style.display = "block";
    } else {
        product.style.display = "none";
    }
    if (productBackdrop.style.display === "none") {
        productBackdrop.style.display = "block";
    } else {
        productBackdrop.style.display = "none";
    }
}
let controller = new ScrollMagic.Controller();
let timeline = new TimelineMax();

timeline
    .from(".mainImg", 3, {y: -50}, {y: 0, duration: 3})
    .to('.content', 3, {top: '110%'}, "-=3")
    .to('.columnHeight', 3, {top: '110%'}, "-=3");

let scene = new ScrollMagic.Scene({
    triggerElement: "section",
    duration: "100%",
    triggerHook: 0,
})
    .setTween(timeline)
    .setPin("section")
    .addTo(controller);
