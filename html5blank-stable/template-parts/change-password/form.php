<!-- PERNILLA START -->
<form method="POST" action="<?php echo get_template_directory_uri(); ?>/lib/change-password.php" id="change-password" class="change-password">
  <input id="pass1" type="password" placeholder="Nytt lösenord" required>
  <p>Minst 7 tecken</p>
  <input id="pass2" type="password" placeholder="Bekräfta nytt lösenord" required>
  <p>Minst 7 tecken</p>
  <button type="submit" value="Uppdatera lösenord" class="form-changepassword-button">Ändra lösenord</button>
  <ul id="change-password-messages" class="change-password-messages"></ul>
</form>
<!-- PERNILLA START -->