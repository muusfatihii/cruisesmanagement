window.onload = function (){
    

    $(document).on("click",".deletePort",function(){


        var idPort = $(this).attr("id");
    
        deletePort(idPort);
        
    
    })

}

function deletePort(idPort){


    $.ajax({
        url: "/cruises/public/port/delete",
        method: "POST",
        data: {
            idPort: idPort,
        },
        success:function(data){

            if(data!=1){

            resS=JSON.parse(data);

                output = ``;

                resS.forEach(res=>{

                    output += `<tr>`;

                    output +=`<td>`+res['name']+`</td>`;
                    output +=`<td>`+res['country']+`</td>`;
                    output += `<td><a href="/cruises/public/page/modifyport/`+res['id']+`" ><i class="bi bi-x"></i></a></td>`;
                    output += `<td><i id="`+res['id']+`" class="deletePort bi bi-trash"></i></td>`;

                    output += `</tr>`;

                    
                });


                $('#ports').html(output);

            }else{

                alert("le port ne peut pas etre supprimé");

            }

        },
    });

}



