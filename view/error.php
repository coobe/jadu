<script type="application/javascript">
    $(document).ready(function() {
        $("#error-box").fadeIn(1800).fadeOut(1800);   
    });
</script>

<div id="error-box" class="message alert alert-danger">
    <p>There was an error: <?php echo $errorMessage; ?></p>
</div>