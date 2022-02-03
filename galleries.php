<?php
include_once "includes/header-all.php";
$catQuery = "SELECT * FROM `brockphotography_catagory`";

$catResult = mysqli_query($db, $catQuery) or die('Error loading catalog.');

$cat = mysqli_fetch_array($catResult, MYSQLI_ASSOC)
?>
<form method="get">
    <div id="contentGal">
        <div class="galleries">
            <div class="containerImg">
                <div><img src="images/landscapes/gal_image.jpg" alt="Landscapes. " height="300" width="300" class="imgGallery"></div>
                <a href="landscapes.php?CategoryId=1"><div class="overlay"><div class="imgText">Landscapes</div></div></a>
            </div>
        </div>
    </div>
    <div id="contentGal">
        <div class="galleries">
            <div class="containerImg">
                <div><img src="images/food/DSC_0003.jpg" alt="Landscapes. " height="300" width="300" class="imgGallery"></div>
                <a href="landscapes.php?CategoryId=2"><div class="overlay"><div class="imgText">Landscapes</div></div></a>
            </div>
        </div>
    </div>
</form>
<?php
    include_once "includes/footer-all.php";
?>
<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="jquery.hashchange.min.js"></script>
<script src="jquery.easytabs.min.js"></script>
<script src="script.js"></script>
</body>
</html>