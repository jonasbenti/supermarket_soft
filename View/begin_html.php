<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>SupermaketSoft: <?= $title; ?></title>
        <link rel="icon" type="image/x-icon" href="images/shop.svg">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2">
            <div class="container-fluid">
                <a class="navbar-brand" href="/home">Home</a>
                <a class="navbar-brand" href="/product-type">Tipos de produto</a>
                <a class="navbar-brand" href="/product">Produtos</a>
                <a class="navbar-brand" href="/order-sale-create">Criar Pedido</a>
                <a class="navbar-brand" href="/order-sale">Pedidos</a>
            </div>
        </nav>
        <div class="container">
            <div class="card bg-<?= $button_type; ?> text-white mb-2" style="border-radius: 25px;">
                <div class="card-body">
                    <h2 class="card-title text-center">SupermarketSoft: <?= $title; ?></h2>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>