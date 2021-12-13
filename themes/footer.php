
<footer class="footer">
    <div class="container">
        <span class="text-center"><?php echo date('Y').' @ PT. Majoo Teknologi Indonesia';?></span>
    </div>
</footer>

<?php
echo '
<script src="'.THEME_DIR_URL.'assets/js/jquery.js"></script>
<script src="'.THEME_DIR_URL.'assets/js/bootstrap.js"></script>

';
?>

<?php if (!empty($js_link)) echo $js_link; ?>

<script type="text/javascript">
    <?php if (!empty($js_embed)) echo $js_embed; ?>
    $(document).ready(function() {
        <?php if (!empty($js_onready)) echo $js_onready; ?>
    });
</script>

</body>
</html>