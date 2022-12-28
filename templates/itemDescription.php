<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="flex items-center justify-center h-screen bg-orange-300">
    <!--<main class="flex items-center justify-center h-screen bg-orange-300">-->

        <div class="bg-white w-96 p-6 rounded shadow-sm">
            
                <div class="flex items-center justify-center mb-4">
                    <img src="<?=$cruise->pic;?>" alt="" class="h-32" />
                </div>
                <label class="text-orange-400" for="">Départ</label>
                <input 
                class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded"
                type="text" 
                disabled=true
                value="<?=$cruise->departurePort;?>"
                />
                <label class="text-orange-400" for="">Nuits</label>
                <input 
                class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded"
                type="text" 
                disabled=true
                value="<?=$cruise->nbrNights;?>"
                />
                <label class="text-orange-400" for="">Date de départ</label>
                <input 
                class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4 rounded" 
                type="text"
                disabled=true 
                value="<?=$cruise->departureDate;?>"
                />
                <form action="index.php?action=reserve&idCruise=<?=$cruise->id?>" method="POST" class="mb-4">
                 <?php foreach($roomTypes as $roomType){
                if($roomType->available):?>
                <input type="radio" id="roomType" name="roomType" class="mb-4" value="<?=$roomType->id?>"/> <?=$roomType->name?> <?=$roomType->price?><br/>  
                <?php endif; }?>
                
                <button 
                type="submit"
                class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors">
                Je reserve</button>
                
                </form>
                
                <button 
                onclick="history.back()" 
                class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-orange-700 transition-colors">
                Go back</button>

            
       </div>

    <!-- </main> -->
    
</body>
</html>

