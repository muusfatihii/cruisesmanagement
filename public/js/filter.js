window.onload = function (){

    var portName = document.getElementById("portName");
    var shipName = document.getElementById("shipName");
    var departureMonth = document.getElementById("departureMonth"); 

    portName.addEventListener('change',function(){

        fetchData(1,portName.value,shipName.value,departureMonth.value)
        
        
    })

    shipName.addEventListener('change',function(){

        fetchData(1,portName.value,shipName.value,departureMonth.value)
        
        
    })

    departureMonth.addEventListener('change',function(){

        fetchData(1,portName.value,shipName.value,departureMonth.value)
        
        
    })


    $(document).on("click",".page-link",function(){

        var page = $(this).attr("id");
    
        fetchData(page,portName.value,shipName.value,departureMonth.value);

    
    })

}

function fetchData(page,portName,shipName,departureMonth){


    $.ajax({
        url: "/cruises/public/cruise/filter/",
        method: "POST",
        data: {
            page: page,
            portNameId: portName,
            shipNameId: shipName,
            departureMonthId: departureMonth
        },
        success:function(response){


            $("#cruises").html(response);

           
        },
    });

}


