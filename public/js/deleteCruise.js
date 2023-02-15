window.onload = function (){
    

    $(document).on("click",".cancelCruise",function(){

        var idCruise = $(this).attr("id");
    
        cancelCruise(idCruise);

    
    })

}

function cancelCruise(idCruise){


    $.ajax({
        url: "/cruises/public/cruise/cancel",
        method: "POST",
        data: {
            idCruise: idCruise,
        },
        success:function(data){

            if(data!=1){

            resS=JSON.parse(data);

                output = ``;

                resS.forEach(res=>{

                    output += `<tr>`;

                    output += `<th scope="row"><img src="/cruises/public/uploads/`+res['pic']+`" style="height:32px;width:32px;" alt=""></th>`;
                    output += `<td>`+res['departurePort']+`</td>`;
                    output += `<td>`+res['ship']+`</td>`;
                    output += `<td>`+res['nbrNights']+`</td>`;
                    output += `<td>`+res['minPrice']+`</td>`;
                    output += `<td>`+res['departureDate']+`</td>`;
                    output += `<td><a href="/cruises/public/page/modifycruise/`+res['id']+`" ><i class="bi bi-x"></i></a></td>`;
                    output += `<td><i id="`+res['id']+`" class="cancelCruise bi bi-x"></i></td>`;
                    

                    output += `</tr>`;

                    
                });


                $('#cruises').html(output);

            }else{

                alert("la croisière ne peut plus etre annulée");

            }

        },
    });

}



