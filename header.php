<link type="text/css" rel="stylesheet" href="popupforms.css">
<link type="text/css" rel="stylesheet" href="styles/header.css">
<link type="text/css" rel="stylesheet" href="styles/search.css">

<div class="topnav sticky" id="myTopnav">
    <a href="index.php" class="logo">
        <svg class="logo" viewBox="0 0 1000 1000" role="presentation" aria-hidden="true" focusable="false"
             style="height: 1em; width: 1em; display: block; fill: currentcolor;">
            <path d="m499.3 736.7c-51-64-81-120.1-91-168.1-10-39-6-70 11-93 18-27 45-40 80-40s62 13 80 40c17 23 21 54 11 93-11 49-41 105-91 168.1zm362.2 43c-7 47-39 86-83 105-85 37-169.1-22-241.1-102 119.1-149.1 141.1-265.1 90-340.2-30-43-73-64-128.1-64-111 0-172.1 94-148.1 203.1 14 59 51 126.1 110 201.1-37 41-72 70-103 88-24 13-47 21-69 23-101 15-180.1-83-144.1-184.1 5-13 15-37 32-74l1-2c55-120.1 122.1-256.1 199.1-407.2l2-5 22-42c17-31 24-45 51-62 13-8 29-12 47-12 36 0 64 21 76 38 6 9 13 21 22 36l21 41 3 6c77 151.1 144.1 287.1 199.1 407.2l1 1 20 46 12 29c9.2 23.1 11.2 46.1 8.2 70.1zm46-90.1c-7-22-19-48-34-79v-1c-71-151.1-137.1-287.1-200.1-409.2l-4-6c-45-92-77-147.1-170.1-147.1-92 0-131.1 64-171.1 147.1l-3 6c-63 122.1-129.1 258.1-200.1 409.2v2l-21 46c-8 19-12 29-13 32-51 140.1 54 263.1 181.1 263.1 1 0 5 0 10-1h14c66-8 134.1-50 203.1-125.1 69 75 137.1 117.1 203.1 125.1h14c5 1 9 1 10 1 127.1.1 232.1-123 181.1-263.1z"></path>
        </svg>
    </a>
    <a id="arrow-icon" href="javascript:void(0);" class="arrow-icon" onclick="respNavBar()">
        <i id="down" class="fa fa-angle-down"></i>
    </a>
    <div class="nav-search-wrapper" id="nav-search-wrapper">
        <form method="GET" action="">
            <svg id="search-img" viewBox="0 0 24 24" role="presentation" aria-hidden="true" focusable="false"
                 style="height: 16px; width: 16px; display: block; fill: currentcolor;">
                <path d="m10.4 18.2c-4.2-.6-7.2-4.5-6.6-8.8.6-4.2 4.5-7.2 8.8-6.6 4.2.6 7.2 4.5 6.6 8.8-.6 4.2-4.6 7.2-8.8 6.6m12.6 3.8-5-5c1.4-1.4 2.3-3.1 2.6-5.2.7-5.1-2.8-9.7-7.8-10.5-5-.7-9.7 2.8-10.5 7.9-.7 5.1 2.8 9.7 7.8 10.5 2.5.4 4.9-.3 6.7-1.7v.1l5 5c .3.3.8.3 1.1 0s .4-.8.1-1.1"
                      fill-rule="evenodd"></path>
            </svg>
            <div class="dropdown">
                <input class="nav-search dropbtn" type="text" name="search" id="nav-search" autocomplete="off"
                       placeholder='Try "Bali"' onclick='search_bar()' onkeyup="filterFunction()"/>
            </div>
        </form>
    </div>
    <div id="side-btn" class="side-btn">
        <?php
        if (!isset($_SESSION['id'])) {
            echo "<a class='btn' onclick='login()'>Add Housing</a>";
            echo "<a class='btn' onclick='register()'>Register</a>";
            echo "<a class='btn' onclick='login()'>Log in</a>";
        } else {
            echo "<a class='btn' onclick='addhousing()'>Add Housing</a>";
            echo "<a class='btn' href='user_profile.php'>Profile</a>";
            echo "<a class='btn' href='logout.php'>Log out</a>";
        }
        ?>
    </div>
    <?php
    if (!isset($_SESSION['id'])) {
        echo "<a id='burger-icon' href=\"javascript:void(0);\" class=\"icon\" onclick=\"respNavBar()\">
                <i class=\"fa fa-bars\"></i>
                </a>";
    } else {
        $user_icon = $db->retrieveUser($_SESSION['id'])->getAvatar();
        echo "<img id='user-img' src='$user_icon' class='btn dropbtn resp-icon' alt='User' onclick=\"respNavBar()\">";
    }
    ?>
</div>
<div id="drop_down" class="dropdown-content">
    <?php
    $db = new RentalDatabase();
    $locations = $db->getLocations();
    foreach ($locations as $l) {
        echo "<a href='location_search.php?location=$l'>$l</a>";
    }
    ?>
</div>

<script>
    function respNavBar() {
        var sidebtn = document.getElementById("side-btn");
        sidebtn.classList.toggle("responsive");

        var myNavBar = document.getElementById("myTopnav");
        myNavBar.classList.toggle("bigger-header");

        var pageTitle = document.getElementById("page-title");
        pageTitle.classList.toggle("lower-top");

    }

    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("nav-search");
        filter = input.value.toUpperCase();
        div = document.getElementById("drop_down");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }

</script>