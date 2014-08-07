<?php
require_once('vendor/autoload.php');

// local downloads
$redis = new Redis();
$redis->connect('127.0.0.1');
$keys = $redis->keys("flvmeta:downloads:*");

$total = 0;

// github downloads
$gh = new \Github\Client();
$releases = $gh->api('repo')->releases()->all('noirotm', 'flvmeta');

?>
<html>
<head>
    <title>File list</title>
</head>
<body>
<h1>File list</h1>
<table border="1">
    <tr>
        <td><b>Website</b></td>
        <td><b>File</b></td>
        <td><b>Downloads</b></td>
    </tr>

    <?php
    foreach ($keys as $k):
        $filename = str_replace('flvmeta:downloads:', '', $k);

        if (empty($filename)) continue;

        $downloads = $redis->get($k);
        $total += intval($downloads);
        ?>
        <tr>
            <td>flvmeta.com</td>
            <td><?= $filename ?></td>
            <td><?= $downloads ?></td>
        </tr>
    <?php endforeach; ?>

    <?php foreach ($releases as $release): ?>
        <?php foreach ($release['assets'] as $asset):
            $total += intval($asset['download_count']);
        ?>
            <tr>
                <td>github.com</td>
                <td><?= $asset['name'] ?></td>
                <td><?= $asset['download_count'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <tr>
        <td><i>Total</i></td>
        <td>&nbsp;</td>
        <td><?= $total ?></td>
    </tr>

</table>
</body>
</html>