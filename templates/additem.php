<?php $title="Add Item"?>

<?php ob_start(); ?>

<div class="flex items-center justify-center h-[800px] bg-orange-300">



<form method="POST" action="index.php?action=addItem" enctype="multipart/form-data" class="bg-white w-96 p-6 rounded shadow-sm">

        <label for="nomproduit" class="text-orange-400">Nom</label>
        <input type="text" 
        class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
        id="nomproduit" 
        name="name" required>



    
      <label for="picproduit" class="text-orange-400">Photo</label>
      <input 
      class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
      id="nomproduit" 
      type="file" 
      id="picproduit" 
      name="pic">

    <label for="quantiteproduit" class="text-orange-400">Quantité</label>
    <input 
    type="nombre" 
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    id="quantiteproduit" 
    name="quantity" 
    required>

    <label for="prixproduit" class="text-orange-400">Prix</label>
    <input 
    type="nombre" 
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    id="prixproduit" 
    name="price" 
    required>


    <label for="categorie" class="text-orange-400">Catégorie</label>
    <select 
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    name="idCategory" 
    id="categorieproduit" 
    required>
            <option value=""></option>
            <?php
                foreach($categories as $category){
            ?>
            <option  value="<?=$category->id;?>"><?=$category->name; ?></option>
            <?php
            }
            ?>
    </select>

    <label for="descriptionitem" class="text-orange-400">Description</label>

    <input 
    type="text" 
    class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
    id="descriptionitem" 
    name="description"
    >
    
    <button type="submit" 
    class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors" 
    id="submitbtn">Ajouter</button>
</form>


</div>


<?php $content = ob_get_clean(); ?>


<?php require('layout.php') ?>



