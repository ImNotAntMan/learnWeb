<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <ol>
    @foreach ($articles as $article)    // ArticleController에서 생성한 $articles를 받아서 $article에 저장
    <li>{{ $article->title }}</li>
    @endforeach
    </ol>
</body>
</html>