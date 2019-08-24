<div class="h_title">
Get Site and Database Backup
</div>
<div class="message_box">
<?php
if (isset($success) && strlen($success)) {
echo '<div class="success">';
echo '<p>' . $success . '</p>';
echo '</div>';
}
 
if (isset($errors) && strlen($errors)) {
echo '<div class="error">';
echo '<p>' . $errors . '</p>';
echo '</div>';
}
 
if (validation_errors()) {
echo validation_errors('<div class="error">', '</div>');
}
?>
</div>
<?php
$back_url = $this->uri->uri_string();
$key = 'referrer_url_key';
$this->session->set_flashdata($key, $back_url);
?>
<div class="body body-s">
<?php
echo form_open($this->uri->uri_string());
?>
<fieldset>
<section>
<label>Backup Type</label>
<label>
<select name="backup_type">
<option value="" selected disabled>Backup Type</option>
<option value="1" <?php echo (isset($success) && strlen($success) ? '' : (set_value('backup_type') == '1' ? 'selected' : '')) ?>>DB Backup</option>
<option value="2" <?php echo (isset($success) && strlen($success) ? '' : (set_value('backup_type') == '2' ? 'selected' : '')) ?>>Site Backup</option>
</select>
</label>
</section>
 
<section>
<label>File Type</label>
<label>
<select name="file_type">
<option value="" selected disabled>File Type</option>
<option value="1" <?php echo (isset($success) && strlen($success) ? '' : (set_value('file_type') == 1 ? 'selected' : '')) ?>>ZIP</option>
<option value="2" <?php echo (isset($success) && strlen($success) ? '' : (set_value('file_type') == 2 ? 'selected' : '')) ?>>GZIP</option>
</select>
</label>
</section>
</fieldset>
 
<footer>
<button type="submit" name="backup" value="backup" class="button">Get Backup</button>
</footer>
<?php
echo form_close();
?>
</div>