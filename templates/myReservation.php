<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <table>
        <tr>
            <th>Photo croisière</th>
            <th>Port de départ</th>
            <th>Date de départ</th>
            <th>Réservée le </th>
            <th>Prix de réservation</th>
        </tr>
        <?php
        foreach($reservations as $reservation){
        ?>
        <tr>
            <td><?=$reservation->cruisePic?></td>
            <td><?=$reservation->departurePort?></td>
            <td><?=$reservation->departureDate?></td>
            <td><?=$reservation->reservationDate?></td>
            <td><?=$reservation->reservationPrice?></td>
            <td><a href="index.php?action=cancelReservation&id=<?=$reservation->id?>">cancel</a></td>

        </tr>
        <?php
        }
        ?>
        
        </table>

</body>
</html>
