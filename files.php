<?php
$redis = new Redis();
$redis->connect('127.0.0.1');
$keys = $redis->keys("flvmeta:downloads:*");

$total = 0;
?>
<html>
<head>
<title>File list</title>
</head>
<body>
<h1>File list</h1>
<table>
<tr>
<td><b>File</b></td>
<td><b>Downloaded</b></td>
</tr>
<?php foreach($keys as $k):
    $filename = preg_replace('/^:/g', '', $k);
    $downloads = $redis->get($k);
    $total += intval($downloads);
?>
<tr>
<td><?= $filename ?></td>
<td><?= $downloads ?></td>
</tr>
<?php endforeach; ?>

<tr>
<td><i>Total</i></td>
<td><?= $total ?></td>
</tr>

</table>
</body>
</html>