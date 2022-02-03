<script>
    window.onload = function () {
        var store = document.getElementById("shoppingCart");
        var storeBackdrop = document.getElementById("storeBackdrop");
        store.style.display = "none";
        storeBackdrop.style.display = "none";
    }
    function storePopUp() {
        var store = document.getElementById("shoppingCart");
        var storeBackdrop = document.getElementById("storeBackdrop");
        if (store.style.display === "none") {
            store.style.display = "block";
        } else {
            store.style.display = "none";
        }
        if (storeBackdrop.style.display === "none") {
            storeBackdrop.style.display = "block";
        } else {
            storeBackdrop.style.display = "none";
        }
    }
</script>
<form method="post" action="landscapes.php">
<div id="shoppingCart">
    <div class="tabs-content">
        <button type="button" id="x" onclick="storePopUp()">X</button>
        <div id="panels">

            <input id="tab1" type="radio"  checked name="panel_select">
            <input id="tab2" type="radio" name="panel_select">

            <div id="tabs">
                <!--Note that by simply setting the 'for', when you press on a label tag, it will select the appropriate radio-->
                <label for="tab1">Tab 1</label>
                <label for="tab2">Tab 2</label>
            </div>

            <div class="panel" id="panel1">
                <h3>PANEL 1</h3>
            </div>
            <div class="panel"  id="panel2">
                <fieldset>
                    <legend>Shipping Address</legend>
                    <label for="address">Address: </label><input type="text" name="address" id="address" style="width: 25em;"><br>
                    <label for="city">City: </label><input type="text" name="city" id="city" style="width: 100px;">
                    <label for="state">State: </label><input type="text" name="state" id="state" style="width: 20px;">
                    <label for="zip">Zip: </label><input type="text" name="zip" id="zip" style="width: 40px;">
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div id="storeBackdrop"></div>