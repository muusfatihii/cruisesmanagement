window.onload = function (){
    

    $(document).on("click",".cancelRes",function(){

        var resId = $(this).attr("id");
    
        cancelRes(resId);

    })

}

function cancelRes(resId){

    idRes = resId;

    $.ajax({
        url: "/cruises/public/reservation/cancel",
        method: "POST",
        data: {
            idRes: idRes,
        },
        success:function(data){

            if(data!=1){
                
            resS=JSON.parse(data);

                output = ``;

                resS.forEach(res=>{

                    output += `<tr>`;

                    output += `<th scope="row"><img src="/cruises/public/uploads/`+res['pic']+`" style="height:32px;width:32px;" alt=""></th>`;
                    output += `<td>`+res['departurePort']+`</td>`;
                    output += `<td>`+res['departureDate']+`</td>`;
                    output += `<td>`+res['reservationDate']+`</td>`;
                    output += `<td>`+res['reservationPrice']+`</td>`;
                    output += `<td>`+res['roomNbr']+`</td>`;
                    output += `<td><i id="`+res['id']+`" class="cancelRes bi bi-x"></i></td>`;


                    output += `</tr>`;

                    
                });


                $('#reservs').html(output);

            }else{

                alert("La réservation ne peut plus etre annulée!!");

            }


            

        },
    });

}



