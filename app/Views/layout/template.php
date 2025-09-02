<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?= $this->include("layout/css") ?>
</head>
<body>
    <?= $this->include("layout/navbar") ?>
 
    <div class="container">
        <?=  $this->renderSection("content") ?>
    </div>
   
</body>
</html>