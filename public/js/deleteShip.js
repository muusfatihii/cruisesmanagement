window.onload = function (){
    

    


    $(document).on("click",".deleteShip",function(){

        var idShip = $(this).attr("id");
    
        deleteShip(idShip);
    
    })

}

function deleteShip(idShip){


    $.ajax({
        url: "/cruises/public/ship/delete",
        method: "POST",
        data: {
            idShip: idShip,
        },
        success:function(data){

            if(data!=1){

            resS=JSON.parse(data);

                output = ``;

                resS.forEach(res=>{

                    output += `<tr>`;

                    output +=`<td>`+res['name']+`</td>`;
                    output +=`<td>`+res['nbrRooms']+`</td>`;
                    output +=`<td>`+res['nbrPlaces']+`</td>`;
                    output += `<td><a href="/cruises/public/page/modifyship/`+res['id']+`" ><i class="bi bi-x"></i></a></td>`;
                    output += `<td><i id="`+res['id']+`" class="deleteShip bi bi-x"></i></td>`;
                    

                    output += `</tr>`;

                    
                });


                $('#ships').html(output);

            }else{

                alert("le navire ne peut pas etre supprimé");

            }

        },
    });

}



