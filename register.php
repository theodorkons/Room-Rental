<button type="button" id="exitBtn" aria-busy="false">
    <svg viewBox="0 0 24 24" role="img" aria-label="Κλείσιμο" focusable="false"
         style="height: 16px; width: 16px; display: block; fill: rgb(118, 118, 118);">
        <path d="m23.25 24c-.19 0-.38-.07-.53-.22l-10.72-10.72-10.72 10.72c-.29.29-.77.29-1.06 0s-.29-.77 0-1.06l10.72-10.72-10.72-10.72c-.29-.29-.29-.77 0-1.06s.77-.29 1.06 0l10.72 10.72 10.72-10.72c.29-.29.77-.29 1.06 0s .29.77 0 1.06l-10.72 10.72 10.72 10.72c.29.29.29.77 0 1.06-.15.15-.34.22-.53.22"
              fill-rule="evenodd"></path>
    </svg>
</button>
<h2 id="popuptitle">Register</h2>
<form class="custom-form" action="submitReg.php" method="post" enctype="multipart/form-data">
    <input id="fullname" class="customInput" name="name" type="text" placeholder="Full Name" required autofocus>

    <input oninput="isUsernameValid('username');" id="username" class="customInput" name="username" type="text"
           placeholder="Username" required>

    <input id="password" class="customInput" name="password" type="password" placeholder="Password" required>

    <input id="email" class="customInput" name="email" type="email" placeholder="Email Address" required>

    <div class="customInput">
        <label for="avatar">Choose an avatar image</label>
        <input id="avatar" name="avatar" type="file" placeholder="Avatar Image">
    </div>

    <input id="regBtn" type="submit">
</form>
<hr>
<span id="alreadyMember" class="customInput">Already a member? <div id="toLogin" class="link"
                                                                    style="cursor: pointer; display: inline-block;">Log in</div></span>
