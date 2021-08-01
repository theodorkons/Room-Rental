<button type="button" id="exitBtn" aria-busy="false">
    <svg viewBox="0 0 24 24" role="img" aria-label="Κλείσιμο" focusable="false"
         style="height: 16px; width: 16px; display: block; fill: rgb(118, 118, 118);">
        <path d="m23.25 24c-.19 0-.38-.07-.53-.22l-10.72-10.72-10.72 10.72c-.29.29-.77.29-1.06 0s-.29-.77 0-1.06l10.72-10.72-10.72-10.72c-.29-.29-.29-.77 0-1.06s.77-.29 1.06 0l10.72 10.72 10.72-10.72c.29-.29.77-.29 1.06 0s .29.77 0 1.06l-10.72 10.72 10.72 10.72c.29.29.29.77 0 1.06-.15.15-.34.22-.53.22"
              fill-rule="evenodd"></path>
    </svg>
</button>
<h2 id="popuptitle">Add Housing</h2>
<form class="custom-form" action="submitHousing.php" method="post" enctype="multipart/form-data">
    <input type="text" class="customInput" name="title" id="title" placeholder="Title" autofocus required>

    <input type="text" class="customInput" name="location" id="location" placeholder="Location" required>

    <input type="text" class="customInput" name="description" id="description" placeholder="Description" required>

    <input type="date" class="customInput" name="check-in" id="check-in" placeholder="Check In" required>

    <input type="date" class="customInput" name="check-out" id="check-out" placeholder="Check Out" required>

    <div class="customInput" id="photos-div">
        <label for="photos">Choose housing photos</label>
        <input type="file" name="photos[]" class="photos" multiple>
    </div>

    <hr>
    <input id="regBtn" type="submit" name="submit" value="Send &rarr;"/>
</form>