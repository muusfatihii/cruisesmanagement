<?php 

$ship = $data[0];

$title="Add Item"?>

<?php ob_start(); ?>

<div class="flex items-center justify-center h-screen bg-orange-300">



<form method="POST" action="/cruises/public/ship/modify" class="bg-white w-96 p-6 rounded shadow-sm">

        <label for="nameShip" class="text-orange-400">Nom Navire </label>
        <input type="text" 
        readonly
        value=<?=$ship->name?>
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nameShip" 
        name="nameShip" required>

        <label for="nbrRooms" class="text-orange-400">Nombre des chambres </label>
        <input type="number" 
        readonly
        value=<?=$ship->nbrRooms?>
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nbrRooms" 
        name="nbrRooms" required>

        <label for="nbrPlaces" class="text-orange-400">Nombre des places </label>
        <input type="number" 
        readonly
        value=<?=$ship->nbrPlaces?>
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nbrPlaces" 
        name="nbrPlaces" required>

        <input type="text" 
        value=<?=$ship->id?>
        style="display:none;" 
        id="idShip" 
        name="idShip">

    <button type="submit" 
    disabled=true;
    class="bg-orange-500 w-full text-gray-100 py-2 rounded mb-4 hover:bg-orange-700 transition-colors" 
    id="submitbtn">Modifier</button>

    <button type="button" 
    onClick="location.href='/cruises/public/page/shipsdet'" 
    class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors" 
    >Back</button>
</form>


</div>


<?php $content = ob_get_clean(); ?>


<?php require('layout.php') ?>



