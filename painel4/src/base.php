<?php
    include "./templates/header.php";
    include "./templates/menu.php";
?>













<?php
   include './templates/frameworks.html';
?>


<script>
    $(document).ready(function () {
        $('.tabs').tabs();
    });
</script>


<script>
    $(document).ready(function () {
        $('select').formSelect();
    });
</script> 

<?php
   include './templates/footer.html';
?>
