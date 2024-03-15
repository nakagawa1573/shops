<!DOCTYPE html>
<html>
<head>
    <title>予約情報の通知</title>
</head>
<body>
    <div>
        {{$name}}様<br>
        本日、「{{$shop}}」にて予約があります。<br>
        予約時間：{{$time}}<br>
        予約人数：{{$number == 'over_10' ? '10人以上' : $number.'人'}}<br>
        <img src="data:image/gif;base64,<?= $qrCode ?>" alt="">
    </div>
</body>
</html>