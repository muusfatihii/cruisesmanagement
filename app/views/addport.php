<?php $title="Add Port"?>

<?php ob_start(); ?>

<div class="flex items-center justify-center h-screen bg-orange-300">



<form method="POST" action="/cruises/public/port/add" class="bg-white w-96 p-6 rounded shadow-sm">

        <label for="namePort" class="text-orange-400">Nom Port :</label>
        <input type="text" 
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="namePort" 
        name="namePort" required>

        <label for="country" class="text-orange-400">Pays :</label>
        <input type="text" 
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="country" 
        name="country" required>

    <button type="submit" 
    class="bg-orange-500 w-full text-gray-100 py-2 rounded mb-4 hover:bg-orange-700 transition-colors" 
    id="submitbtn">Ajouter</button>

    <button 
    onClick="location.href='/cruises/public/page/portconfig'"
    class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors" 
    >Go Back</button>
</form>


</div>


<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>



