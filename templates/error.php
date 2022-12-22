<?php $title = "error"?>
<?php ob_start(); ?>
<div class="flex items-center justify-center h-screen bg-orange-300">
<p class="text-red-400 font-bold text-center">Une erreur est survenue : <?= $errorMessage ?></p>
</div>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>
