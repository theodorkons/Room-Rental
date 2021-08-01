<button type="button" id="exitBtn" aria-busy="false">
    <svg viewBox="0 0 24 24" role="img" aria-label="Κλείσιμο" focusable="false"
         style="height: 16px; width: 16px; display: block; fill: rgb(118, 118, 118);">
        <path d="m23.25 24c-.19 0-.38-.07-.53-.22l-10.72-10.72-10.72 10.72c-.29.29-.77.29-1.06 0s-.29-.77 0-1.06l10.72-10.72-10.72-10.72c-.29-.29-.29-.77 0-1.06s.77-.29 1.06 0l10.72 10.72 10.72-10.72c.29-.29.77-.29 1.06 0s .29.77 0 1.06l-10.72 10.72 10.72 10.72c.29.29.29.77 0 1.06-.15.15-.34.22-.53.22"
              fill-rule="evenodd"></path>
    </svg>
</button>
<h2 id="popuptitle">Log In</h2>
<form id="login-form" class="custom-form" action="submitLogin.php" method="post">
    <input id="username" name="username" class="customInput" type="text" placeholder="Username" onkeypress="checkLogInPressedKey()" required autofocus>

    <input id="password" name="password" class="customInput" type="password" placeholder="Password" onkeypress="checkLogInPressedKey()" required>

    <span id="error-message"></span>

    <input id="regBtn" class="" type="button" name="submit" value="Submit" onclick="loginRequest()">

    <span id="forgotPassword" class="customInput"><span id="toForgot" class="link">Forgot my password</span></span>
    <hr>
    <span id="alreadyMember" class="customInput">Not a member? <div id="toReg" class="link" style="cursor: pointer; display: inline-block;">Register</div></span>
</form>