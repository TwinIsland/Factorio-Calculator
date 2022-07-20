<h1 style="font-family: fantasy">Factorio Calculator</h1>
<img src="header.jpg">
<form action="">
    <br>
    <label for="module" style="color: brown">Module Name:</label><br>
    <input type="text" id="module" name="module" placeholder="advanced-circuit"><br><br>
    <input type="submit" value="Calculate">
</form>
<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: text/html; charset=utf-8");

if (!isset($_GET["module"]) || strlen($_GET["module"]) < 1 || strlen($_GET["module"]) > 100) {
    exit();
}
$json = file_get_contents('data.json');
$data = json_decode($json,true);

if (!array_key_exists($_GET["module"], $data)) {
    echo "<h4 style='color:red'>No such Recipes</h4>";
    exit();
} else {
    echo "<h4 style='color:green'>Recipes for: ".$_GET["module"]."</h4>";
    get_ing($_GET["module"]);
}

function get_ing($item) {
    global $data;
    if (!empty($data[$item])) {
        $ingredient = $data[$item][0]['ingredients'];
        echo "-----------------<br>";
        echo "<i>Parent: ".$item."</i><br><br>";
        foreach ($ingredient as $item) {
            echo "<b>".$item['name']."</b>: ".$item['amount']."<br>";
        }
        foreach ($ingredient as $item) {
            get_ing($item['name']);
        }
    }
}


