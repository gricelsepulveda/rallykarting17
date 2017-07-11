<?php echo validation_errors(); ?>

<?php
$error_rut = $this->session->flashdata('error_rut');
if(isset($error_rut) && !empty($error_rut)) {
?>
    <div>Rut no válido en nuestros sistemas</div>
<?php } ?>

<?php echo form_open(site_url('frontend/login')); ?>

<input type="text" name="txt_rut"><br>
<input type="text" name="txt_pass"><br>
<input type="submit" value="Ingresar">

<?php echo form_close(); ?>
