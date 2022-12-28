
window.onload=function(){

var selectPortName = document.querySelector('#portName');
var selectShipName = document.querySelector('#shipName');
var selectDepartureMonth = document.querySelector('#departureMonth');



selectPortName.addEventListener('change',function(){
    alert(selectPortName.value);
});

selectShipName.addEventListener('change',function(){
    alert(selectShipName.value);
});

selectDepartureMonth.addEventListener('change',function(){
    alert(selectDepartureMonth.value);
});

}

// function fetchData(page){

//     $.ajax({
//         url: "index.php?actionuuu=cruises",
//         method: "POST",
//         data: {
//             page: page,
//         },
//         success:function(data){

//             $("#cruises").html(data);

//         },
//     });

// }


//fetchData();

// $(document).on("click",".page-item",function(){

//     var page = $(this).attr("id");

//     fetchData(page);

// })

