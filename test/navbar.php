<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-dark-subtle">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>


    <?php
    $cards = [
        [
            "title" => "Card One",
            "text"  => "This is the first card",
            "img"   => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVRoLY3SSqU0HpNAP_-uwfp98RSCrxFqk5Gw&s"
        ],
        [
            "title" => "Card Two",
            "text"  => "This is the second card",
            "img"   => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVRoLY3SSqU0HpNAP_-uwfp98RSCrxFqk5Gw&s"
        ],
        [
            "title" => "Card Three",
            "text"  => "This is the third card",
            "img"   => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVRoLY3SSqU0HpNAP_-uwfp98RSCrxFqk5Gw&s"
        ],
        
    ];
    ?>

    <div class="container mt-4 ">
        <h2 class="text-center">My Dynamic Cards</h2>

        <div class="d-flex gap-5 justify-content-center mt-4 ">
            <?php foreach ($cards as $card): ?>

                <div class="card" style="width: 18rem;">
                    <img src="<?= $card['img'] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $card['title'] ?></h5>
                        <p class="card-text"><?= $card['text'] ?></p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>


    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>