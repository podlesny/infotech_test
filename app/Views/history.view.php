
<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Квест</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<meta name="theme-color" content="#563d7c">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
	  }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
  	</head>
  	<body class="text-center">
	  <?php
		foreach($params['players'] as $player){
	  ?>
		<h3>Игрок: <?=$player['name']?></h3>

	  <div class="row">

		<?php 
			foreach($player->historyItems as $item){
		?>
			<div class="col-md-8 offset-md-2">
				<div class = 'alert alert-primary history-item'>
					<p><?=$item->getText()?></p>
				</div>
			</div>
		<?php
		}
		?>
		</div>
	  <?php
	  }
	  ?>
	</body>
</html>
