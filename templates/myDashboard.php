<?php



foreach($reservations as $reservation){
    echo $reservation->id;
    echo '<br>';
    echo $reservation->reservationDate;
    echo '<br>';
    echo $reservation->reservationPrice;
    echo '<br>';
    echo $reservation->departureDate;
    echo '<br>';
    echo $reservation->departurePort;
    echo '<br>';
    echo $reservation->cruisePic;
    echo '<br>';


}
