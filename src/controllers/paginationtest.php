case 'crois':

require ('templates/cruisesUser.php');

$limit = 4;


if(isset($_POST['page']) && !empty($_POST['page'])){

    $page = $_POST['page'];

}else{

    $page = 1;

}

$start_from = ($page-1)*$limit;

break;
    $output='';

foreach($cruises as $cruise){

    $output.='<div class="card col-12 col-md-6 col-lg-4 col-xl-3 item">
        <img src="uploads/'.$cruise->pic.'" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">'.$cruise->departurePort.'</h5>
            <p class="card-text">A partir de'.$cruise->minPrice.'</p>
            <a href="index.php?action=reserve" class="btn btn-primary item__btn" >Je reserve ma place</a>
        </div>
    </div>';

}


$total_pages = ceil($nbrRows/$limit);


$output.='<ul>';


// if($page>1){
//     $previous = $page--;
//     $output.='
//     <li class="page-item" id="1" ><span class="page-link">First Page</span></li>
//     ';
//     $output.='
//     <li class="page-item" id="'.$previous.'" ><span class="page-link"><i class="fa fa-arrow-left"></i></span></li>
//     ';
// }


for($i=1;$i<=$total_pages;$i++){

    $output.=$i;

    //$output.='<li class="page-item" id="'.$i.'"><a>'.$i.'</a></li>';

}






// if($page<$total_pages){
//     $next = $page++;
//     $output.='
//     <li class="page-item" id="'.$next.'" ><span class="page-link"><i class="fa fa-arrow-right"></i></span></li>
//     ';
//     $output.='
//     <li class="page-item" id="'.$total_pages.'" ><span class="page-link">Last Page</span></li>
//     ';
    
// }

$output.='</ul>';

echo $output;