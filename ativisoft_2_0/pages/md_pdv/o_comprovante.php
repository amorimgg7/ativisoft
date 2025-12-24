<?php
$print = isset($_GET['print']);
?>

<?php if ($print): ?>
<script>
  window.onload = function () {
    window.print();
  };
</script>
<?php endif; ?>
