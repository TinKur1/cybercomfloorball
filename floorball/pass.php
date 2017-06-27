<?php

?>

<html>
<body>
<?php

if (!empty($_GET['myNumber'])):
$num = $_GET['myNumber'];
$fruit = $_GET['myFruit'];
echo "Number: ".$num."  Fruit: ".$fruit;
endif;

if(!empty($_GET['link'])):
if ($_GET['link']=='Link1')
{
echo "Link 1 Clicked";
} else {
echo "Link 2 Clicked";
}
endif;
?>
</body></html>