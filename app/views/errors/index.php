<?php

$pageTitle = 'Error';

include_once 'app/views/partials/header.php';
?>
<div class="row">
    <div class="col-12 pt-2">
        <h1 class="display-one">Error</h1>
        <p><?php echo $message ?></p>
    </div>
</div>
<?php include_once 'app/views/partials/footer.php'; ?>
