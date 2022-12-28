<?php $title="Add Item"?>

<?php ob_start(); ?>

<div class="flex items-center justify-center h-[800px] bg-orange-300">



<form method="POST" action="index.php?action=addShip" class="bg-white w-96 p-6 rounded shadow-sm">

        <label for="nameShip" class="text-orange-400">Nom Navire </label>
        <input type="text" 
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nameShip" 
        name="nameShip" required>

        <label for="nbrRooms" class="text-orange-400">Nombre des chambres </label>
        <input type="number" 
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nbrRooms" 
        name="nbrRooms" required>

        <label for="nbrPlaces" class="text-orange-400">Nombre des places </label>
        <input type="number" 
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nbrPlaces" 
        name="nbrPlaces" required>

    <button type="submit" 
    class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors" 
    id="submitbtn">Ajouter</button>
</form>


</div>


<?php $content = ob_get_clean(); ?>


<?php require('layout.php') ?>



