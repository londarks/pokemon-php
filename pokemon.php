<?php
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

$data =  json_decode(CallAPI("GET","https://pokeapi.co/api/v2/pokemon/?limit=100&offset=0"), true);

$pokemons = array();

// var_dump($data);

// print_r($data['results']);

foreach ($data['results'] as $value) {
    # code...
    $name = $value["name"];
    //download img pokemon
    $data_poke =  json_decode(CallAPI("GET",$value["url"]), true);
    //criando dicionario com nome e e foto do pokemon
    $img_default = $data_poke["sprites"]["front_default"];
    $type = $data_poke["types"][0]["type"]["name"];
    array_push($pokemons, ["name" => $name,
                           "img" => $img_default,
                           "type" => $type]);
    echo "\n";
}
//  <?php print_r($pokemon) 
// print_r($pokemon);
?>

<!doctype html>
<html lang="pt-Br   ">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">x
  <style><?php require("css/style.css");?></style>
  <title>
    Pokedex
  </title>
</head>
<body>

    <div class="container">
        <h1>Pokédex</h1>
        <ul data-js="pokedex" class="pokedex">
        <?php
        foreach ($pokemons as $key => $pokemon) {
            # code...
            echo '<li class="card '.$pokemon["type"].'">';
            echo '<img class="card-image alt="${name}" src="'.$pokemon["img"].'"</img>';
            echo '<h2 class="card-title">'.$pokemon["name"].'</h2>';//#3
            echo '<p class="card-subtitle">'.$pokemon["type"].'</p>';
            echo '</li>';

        }

        ?>
        </ul>

    </div>

</body>
</html>
