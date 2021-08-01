document.addEventListener("DOMContentLoaded", function () {
    var overlay = document.getElementById("overlay");
    overlay.addEventListener("click", overlayOff, false);
});

function close() {
    var popup = document.getElementById("popup");
    popup.innerHTML = "";
    popup.style.display = "none";

    //unblur the rest
    overlayOff();
}

function login() {
    var getLoginFormHTML = new XMLHttpRequest();
    getLoginFormHTML.open("GET", "login.php", true);

    getLoginFormHTML.onreadystatechange = function () {
        if (getLoginFormHTML.readyState === 4) {
            if (getLoginFormHTML.status === 200) {
                // fill div with the form's html
                var popup = document.getElementById("popup");
                popup.innerHTML = getLoginFormHTML.responseText;

                // add close action to the exit button
                var exitBtn = document.getElementById("exitBtn");
                exitBtn.addEventListener("click", close);

                //blur the rest
                overlayOn();

                // show the pop-up
                popup.style.display = "block";

                var linkToReg = document.getElementById("toReg");
                linkToReg.onclick = register;
            } else {
                alert("Σφάλμα " + getLoginFormHTML.status + ": " + getLoginFormHTML.statusText);
            }
        }
    };
    getLoginFormHTML.send(null);
}

function register() {
    var getRegFormHTML = new XMLHttpRequest();
    getRegFormHTML.open("GET", "register.php", true);

    getRegFormHTML.onreadystatechange = function () {
        if (getRegFormHTML.readyState === 4) {
            if (getRegFormHTML.status === 200) {
                // fill div with the form's html
                var popup = document.getElementById("popup");
                popup.innerHTML = getRegFormHTML.responseText;

                // add close action to the exit button
                var exitBtn = document.getElementById("exitBtn");
                exitBtn.addEventListener("click", close);

                //blur the rest
                overlayOn();

                // show the pop-up
                popup.style.display = "block";

                var linkToLogin = document.getElementById("toLogin");
                linkToLogin.onclick = login;
            } else {
                alert("Σφάλμα " + getRegFormHTML.status + ": " + getRegFormHTML.statusText);
            }
        }
    };
    getRegFormHTML.send(null);
}

function overlayOn() {
    document.getElementById("overlay").style.display = "block";
}

function overlayOff() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("popup").style.display = "none";
}

function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

function isUsernameValid(key) {
    var xhr = new XMLHttpRequest();
    var usernameElem = document.getElementById("username");
    var username = usernameElem.value;

    var submitBtn = document.getElementById("regBtn");

    xhr.open('GET', 'validateData.php?' + key + '=' + username);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var validUsername = xhr.responseText;
                if (validUsername === "false") {
                    usernameElem.style.color = "red";
                    submitBtn.disabled = true;
                    submitBtn.enabled = false;
                } else if (validUsername === "true") {
                    usernameElem.style.color = "green";
                    submitBtn.enabled = true;
                    submitBtn.disabled = false;

                }
            }
        }
    };
    xhr.send();
}

function loginRequest() {
    var xhr = new XMLHttpRequest();
    var usernameElem = document.getElementById("username");
    var username = usernameElem.value;

    var passwordElem = document.getElementById("password");
    var password = passwordElem.value;

    var errorElem = document.getElementById("error-message");

    xhr.open('POST', 'submitLogin.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var validUsername = xhr.responseText;
                // console.log(validUsername);
                if (validUsername === "false") {
                    errorElem.hidden = false;
                    errorElem.style.color = "red";
                    errorElem.innerText = "Username or password was incorrect!";
                } else if (validUsername === "true") {
                    errorElem.hidden = true;

                    // reload the page
                    location.reload(true);
                }
            }
        }
    };

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send("username=" + username + "&password=" + password);

}

function checkLogInPressedKey() {
    var inputs = document.querySelectorAll("#login-form > *");
    var found = false;
    for (var i = 0; i < inputs.length; i++) {
        if (event.target === inputs[i]) {
            found = true;
        }
    }

    if (found && event.keyCode === 13) {
        document.querySelector("#login-form #regBtn").click();
    }
    found = false;
}

function checkReviewPressedKey() {
    var inputs = document.querySelectorAll("#review-form > *");
    var found = false;
    for (var i = 0; i < inputs.length; i++) {
        if (event.target === inputs[i]) {
            found = true;
        }
    }

    if (found && event.keyCode === 13) {
        document.querySelector("#review-form #regBtn").click();
    }
    found = false;
}

function addhousing() {
    var getAddHFormHTML = new XMLHttpRequest();
    getAddHFormHTML.open("GET", "addhousing.php", true);

    getAddHFormHTML.onreadystatechange = function () {
        if (getAddHFormHTML.readyState === 4) {
            if (getAddHFormHTML.status === 200) {
                // fill div with the form's html
                var popup = document.getElementById("popup");
                popup.innerHTML = getAddHFormHTML.responseText;

                // add close action to the exit button
                var exitBtn = document.getElementById("exitBtn");
                exitBtn.addEventListener("click", close);

                //blur the rest
                overlayOn();

                // show the pop-up
                popup.style.display = "block";

            } else {
                alert("Σφάλμα " + getAddHFormHTML.status + ": " + getAddHFormHTML.statusText);
            }
        }
    };
    getAddHFormHTML.send(null);
}

function search_bar() {
    document.getElementById("drop_down").classList.toggle("show");
}

function book(housing_id) {
    var getBookFormHTML = new XMLHttpRequest();
    getBookFormHTML.open("GET", "book.php?housing_id=" + housing_id, true);

    getBookFormHTML.onreadystatechange = function () {

        if (getBookFormHTML.readyState === 4) {
            if (getBookFormHTML.status === 200) {
                // fill div with the form's html
                var popup = document.getElementById("popup");
                popup.innerHTML = getBookFormHTML.responseText;

                // add close action to the exit button
                var exitBtn = document.getElementById("exitBtn");
                exitBtn.addEventListener("click", close);

                //blur the rest
                overlayOn();

                // show the pop-up
                popup.style.display = "block";

            } else {
                alert("Σφάλμα " + getBookFormHTML.status + ": " + getBookFormHTML.statusText);
            }
        }
    };
    getBookFormHTML.send(null);
}

function review(housing_id) {
    var getReviewFormHTML = new XMLHttpRequest();
    getReviewFormHTML.open("GET", "review_popup.php?housing_id=" + housing_id, true);

    getReviewFormHTML.onreadystatechange = function () {
        if (getReviewFormHTML.readyState === 4) {
            if (getReviewFormHTML.status === 200) {
                // fill div with the form's html
                var popup = document.getElementById("popup");
                popup.innerHTML = getReviewFormHTML.responseText;

                // add close action to the exit button
                var exitBtn = document.getElementById("exitBtn");
                exitBtn.addEventListener("click", close);

                //blur the rest
                overlayOn();

                // show the pop-up
                popup.style.display = "block";

                customizeRating();

            } else {
                alert("Σφάλμα " + getReviewFormHTML.status + ": " + getReviewFormHTML.statusText);
            }
        }
    };
    getReviewFormHTML.send(null);
}

//NOTE initializes the prevSelectedStar to avoid undefined element error
var prevSelectedStar = document.createElement("p");

function customizeRating() {
    var ratingForms = document.querySelectorAll('form.rating-widget');

    for (var i = 0; i < ratingForms.length; i++) {
        var form = ratingForms[i],
            input = form.querySelector('input[type="range"]'),
            size = input.getAttribute('max'),
            ratingWidget = document.createElement('span');

        ratingWidget.classList.add('rating-widget');

        for (var j = size; j > 0; j--) {
            var star = document.createElement('a'), // <a href />, to be focusable
                rating = j;
            star.href = '#';
            star.rating = rating;
            star.classList.add("rating-star");
            star.id = j;

            star.addEventListener('click', saveRating, false);

            ratingWidget.appendChild(star);
        }

        // Insert the widget where the <input> used to be
        input.parentNode.replaceChild(ratingWidget, input);

        // Remove the button
        var button = form.getElementsByTagName('button')[0];
        if (button) {
            button.parentNode.removeChild(button);
        }
    }
}

var rating = 0;

function saveRating() {
    prevSelectedStar.classList.toggle('selected');
    var star = document.querySelector("span.rating-widget a:focus");
    prevSelectedStar = star;
    star.classList.toggle('selected');

    rating = star.id;
    console.log(star.id);

}

function submitReview() {
    var xhr = new XMLHttpRequest();
    var form = document.getElementById('review-form');

    var data = 'housing_id=' + form.querySelector('#housing_id').value + '&rating=' + rating + '&review=' + form.querySelector('#review').value;

    console.log(data);

    xhr.open('POST', 'submitReview.php', true);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                //TODO get response, display message;
                location.reload(true);
            }
            else {
                alert('Error ' + xhr.status + ': ' + xhr.statusText);
            }
        }
    };

    xhr.send(data);
}

function unavail_msg(housing_id) {
    var popup = document.getElementById("popup_msg" + String(housing_id));
    popup.classList.toggle("show");
    var popups = document.getElementsByClassName("popuptext");
    var j;
    for (j = 0; j < popups.length; j++) {
        var popup2 = popups[j];
        if (popup2.id !== popup.id) {
            popup2.classList.remove("show");
            popup2.classList.remove("selected-popup");
        }
    }
    ;
    popup.classList.toggle("selected-popup");
}

window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {

        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }

    if (!event.target.matches('.popup-btn')) {
        var popup = document.getElementsByClassName("selected-popup")[0];
        popup.classList.toggle("show");
        popup.classList.toggle("selected-popup");
    }

};