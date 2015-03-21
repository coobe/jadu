<script type="application/javascript">
    $(document).ready(function() {
        $("#error-box").fadeIn(1).fadeOut(5800);   
    });
</script>

<div id="error-box" class="message alert alert-danger">
    <p>There was an error: <?php echo $errorMessage; ?></p>
</div>