<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    include_once dirname(__FILE__) . '/database.php';

    
    ?>
   <table class="center">
    <thead>
    <th scope="col">ID</th>
    <th scope="col">Temp</th>
    <th scope="col">Humidity</th>
    <th scope="col">Time</th>
    </thead>
  

   <tbody>
    <?php
        $sql = "SELECT * FROM `iotlog` "; //ORDER BY `id` DESC LIMIT 5
        $query = $db->query($sql);
        $result = $query->fetchAll();

            foreach($result as $row){
    ?>
    <tr align="center">
        <th scope="row">
            <?php print $row['id'];?>
        </th>
        <td>
        <?php print $row['temp'];?>
        </td>
        <td>
        <?php print $row['humidity'];?>
        </td>
        <td>
        <?php print $row['timestamp'];?>
        </td>
    </tr>
    <?php } ?>
   </tbody>
   </table>

</body>
</html>