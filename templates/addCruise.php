<?php $title="Add Cruise"?>

<?php ob_start(); ?>

<div class="flex items-center justify-center h-screen bg-orange-300">



<form method="POST" action="index.php?action=addCruise" enctype="multipart/form-data" class="bg-white w-96 p-6 rounded shadow-sm">

      <label for="shipName" class="text-orange-400">Navire </label>

      <select 
      class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
      name="shipID" 
      id="shipName" 
      required>
              <option value=""></option>
              <?php
                  foreach($ships as $ship){
              ?>
              <option  value="<?=$ship->id;?>"><?=$ship->name; ?></option>
              <?php
              }
              ?>
      </select>

      <label for="picCruise" class="text-orange-400">Photo de croisière </label>

      <input 
      class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
      id="picCruise" 
      type="file" 
      name="picCruise">

    <label for="nbrNights" class="text-orange-400">Nombre de nuits </label>
    <input 
    min=1
    type="number" 
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    id="nbrNights" 
    name="nbrNights" 
    required>

    <label for="portName" class="text-orange-400">Port de départ </label>

    <select 
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    name="departurePortID" 
    id="portName" 
    required>
            <option value=""></option>
            <?php
                foreach($ports as $port){
            ?>
            <option  value="<?=$port->id;?>"><?=$port->name; ?>-<?=$port->country; ?></option>
            <?php
            }
            ?>
    </select>

    <label for="departureDate" class="text-orange-400">Date de départ </label>

    <input 
    type="date" 
    min="<?= date('Y-m-d'); ?>"
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    id="departureDate" 
    name="departureDate" 
    required>

    <button type="submit" 
    class="bg-orange-500 w-full text-gray-100 py-2 mb-4 rounded hover:bg-orange-700 transition-colors" 
    id="submitbtn">Ajouter</button>

    <button type="button" 
    onClick="location.href='index.php?action=cruisesDashboard'" 
    class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors" 
    id="submitbtn">Back</button>
    
</form>


</div>


<?php $content = ob_get_clean(); ?>


<?php require('layout.php') ?>



