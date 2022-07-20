<img src="header.jpg">
<form action="">
    <br>
    <label for="module" style="color: brown">Module Name:</label><br>
    <input type="text" id="module" name="module" placeholder="advanced-circuit"><br><br>
    <label for="amount" style="color: brown">Produce Amount:</label><br>
    <input type="text" id="amount" name="amount" placeholder="1"><br><br>
    <input type="submit" value="Calculate">
</form>

<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: text/html; charset=utf-8");

if (!isset($_GET["module"]) || strlen($_GET["module"]) < 1 || strlen($_GET["module"]) > 100) {
    exit();
} else {
    $module = strtolower(trim($_GET["module"]));
}
if (!isset($_GET["amount"]) || strlen($_GET["amount"]) < 1 || strlen($_GET["amount"]) > 100) {
    $amount = 1;
} else {
    $amount = intval($_GET["amount"]);
}

$json = file_get_contents('data.json');
$data = json_decode($json, true);
$id = 0;
$cur_parent = NAN;

if (!array_key_exists($module, $data)) {
    echo "<h4 style='color:red'>No such Recipes</h4>";
//    echo '<form action=""><input type="submit" value="Load Module"></form>';
//    foreach ($data as $module) {
//        print_r($module);
//    }

    exit();
} else {
    echo "<h4 style='color:green'>Recipes for produce: " . $module . " for amount: ".$amount."</h4>";
    echo "<p style='color: brown'>* : raw resources</p>";
    echo_ing($module);
}

function echo_ing($item)
{
    global $data;
    global $id;
    global $cur_parent;
    global $amount;
    if (!empty($data[$item])) {
        $ingredient = $data[$item][0]['ingredients'];
        echo "<div id=" . $id++ . " style='margin-left: " . ($cur_parent == $item || $id == 1 ? 0 : 50) . "'>";
        //echo "<i>Parent: " . $item . "</i><br><br>";
        foreach ($ingredient as $ing) {
            if (empty($data[$ing['name']])) echo "*";
            echo "<b>" . $ing['name'] . "</b>: " . intval($ing['amount']) * $amount . "<br>";
            echo_ing($ing['name']);
        }
        if ($cur_parent != $item) echo '</div>';
    }
}

