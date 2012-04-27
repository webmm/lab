<?php if (isset($_GET['pid'])) $tasca = Tasca::delete($_GET['pid']);
header("Location: /tasques/");
?>
