<?php $title="Modify Cruise"?>

<?php ob_start(); ?>

<div class="flex items-center justify-center h-[1200] bg-orange-300">

<?php


    $cruise = $data[0];
    $ship = $data[1];
    $ships = $data[2];
    $port = $data[3];
    $ports = $data[4];
    $Itinerary = $data[5];

?>

<form method="POST" action="/cruises/public/cruise/modify/<?=$cruise->id?>" enctype="multipart/form-data" class="bg-white w-96 p-6 rounded shadow-sm">

      <label for="shipName" class="text-orange-400">Navire </label>

      <select 
      class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
      name="shipID" 
      id="shipName" 
      required>
              <option value="<?=$ship->id;?>"><?=$ship->name; ?></option>
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
    value="<?=$cruise->nbrNights?>"
    required>

    <label for="portName" class="text-orange-400">Port de départ </label>

    <select 
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    name="departurePortID" 
    id="portName" 
    required>
            <option value="<?=$port->id?>"><?=$port->name?></option>
            <?php
                foreach($ports as $port){
            ?>
            <option  value="<?=$port->id;?>"><?=$port->name; ?></option>
            <?php
            }
            ?>
    </select>

    <label class="text-orange-400">Itinéraire </label>
    <div class="w-full" id="portsContainer">
    <?php 
     $i=1;
    foreach($Itinerary as $it){
        ?>
    <select 
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    name="portId<?=$i?>" 
    id="portId<?=$i?>">
            <option value="<?=$it->idPort;?>"><?=$it->namePort;?></option>
            <?php
                foreach($ports as $port){
            ?>
            <option  value="<?=$port->id;?>"><?=$port->name; ?></option>
            <?php
            }
            ?>
    </select>
    <?php
    $i++;
     }
    ?>
    </div>

    <button type="button" 
    class="bg-orange-500 w-full text-gray-100 py-2 mb-4 rounded hover:bg-orange-700 transition-colors" 
    id="addPort">+</button>

    <button type="button" 
    class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors" 
    id="deletePort">-</button>

    <label for="departureDate" class="text-orange-400">Date de départ </label>
    <input 
    type="date" 
    min="<?= date('Y-m-d'); ?>"
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    id="departureDate" 
    name="departureDate"
    value="<?=$cruise->departureDate?>" 
    required>

    <button type="submit" 
    class="bg-orange-500 w-full text-gray-100 py-2 mb-4 rounded hover:bg-orange-700 transition-colors" 
    id="submitbtn">Modifier</button>
    
    <button type="button" 
    onClick="location.href='/cruises/public/page/cruisesdet'" 
    class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors" 
    >Back</button>
    
</form>


</div>

<script src="/cruises/public/js/addCruise.js"></script>


<?php $content = ob_get_clean(); ?>


<?php require('layout.php') ?>



