<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sign In</title>
</head>
<body>
    <main class="flex items-center justify-center h-screen bg-orange-300">

        <form method="POST" action="index.php?action=signup" class="bg-white w-96 p-6 rounded shadow-sm">
            
                <div class="flex items-center justify-center mb-4">
                    <img src="templates/img/cruise.jpg" alt="logo" class="h-32" />
                </div>
                
                <?php if(!empty($em)):?>
                    <div class="bg-red-500 px-3 py-2 rounded text-gray-100 mb-3">
                    <p><?=$em?></p>
                    </div>
                <?php endif?>

                <label class="text-orange-400" for="">First Name :</label>
                <input 
                class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4"
                name="firstname" 
                type="text" 
                required
                />


                <label class="text-orange-400" for="">Last Name :</label>
                <input 
                class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4"
                name="lastname" 
                type="text" 
                required
                />
                
                <label class="text-orange-400" for="">E-mail :</label>
                <input 
                class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4"
                name="email" 
                type="text" 
                required
                />
                <label class="text-orange-400" for="">Password :</label>
                <input 
                class="w-full py-2 bg-gray-100 text-gray-500 px-1 outline-none mb-4" 
                name="password"
                type="password" 
                required
                />

                <button 
                type="submit" 
                class="bg-orange-500 w-full text-gray-100 py-2 rounded mb-4 hover:bg-blue-700 transition-colors">
                Submit</button>

                <button 
                type="button"
                onClick="location.href='index.php'" 
                class="bg-orange-500 w-full text-gray-100 py-2 rounded hover:bg-blue-700 transition-colors">
                Back</button>

            
        </form>

    </main>
    
</body>
</html>