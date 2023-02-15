<?php $title="Add Item"?>

<?php ob_start(); ?>

<div class="flex items-center justify-center h-[800px] bg-orange-300">



<form method="POST" action="/cruises/public/ship/add" class="bg-white w-96 p-6 rounded shadow-sm">

        <input 
        placeholder="Nom"
        type="text" 
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nameShip" 
        name="nameShip" required>

        <label for="nbrRoomsS" class="text-orange-400">Nombre de chambres Single</label>
        <input type="number"
        value="0" 
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nbrRoomsS" 
        name="nbrRoomsS">

        <label for="priceRoomS" class="text-orange-400">Prix chambre Single</label>
        <input type="number" 
        value="0"
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="priceRoomS" 
        name="priceRoomS">

        <label for="nbrRoomsD" class="text-orange-400">Nombre de chambres Double</label>
        <input type="number" 
        value="0"
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nbrRoomsD" 
        name="nbrRoomsD">

        <label for="priceRoomD" class="text-orange-400">Prix chambre Double</label>
        <input type="number" 
        value="0"
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="priceRoomD" 
        name="priceRoomD">

        <label for="nbrRoomsF" class="text-orange-400">Nombre de chambres Familiales</label>
        <input type="number" 
        value="0"
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nbrRoomsF" 
        name="nbrRoomsF">

        <label for="priceRoomF" class="text-orange-400">Prix chambre Familiale</label>
        <input type="number"
        value="0" 
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="priceRoomF" 
        name="priceRoomF">

        <label for="maxFR" class="text-orange-400">Max Personnes Chambre Familiale </label>
        <input type="number"
        value="0" 
        min=0
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="maxFR" 
        name="maxFR">

    <button type="submit" 
    class="bg-orange-500 w-full text-gray-100 py-2 rounded mb-4 hover:bg-orange-700 transition-colors" 
    id="submitbtn">Ajouter</button>

    <button 
    onClick="location.href='/cruises/public/page/shipconfig'"
    class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors" 
    >Go Back</button>
</form>


</div>


<?php $content = ob_get_clean(); ?>


<?php require('layout.php') ?>



