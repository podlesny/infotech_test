
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
		
		.lead{
			margin-top: 30px;
		}
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.4/examples/cover/cover.css" rel="stylesheet">
  	</head>
  	<body class="text-center">
	  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">

  <main role="main" class="inner cover mt-auto mb-auto">
    <h1 class="h3"><?=$params['text']?></h1>
	<?php
		foreach($params['actions'] as $action){
			if($action['restart']){
				$url = '/restart';
			}
			else if($action['redirect']){
				$url = "/redirect/{$params['id']}/{$action['redirect_step_id']}";
			}
			else{
				$url = "/actions/{$action->id}";
			}
			?>
				<p class="lead">
    			  <a href="<?=$url?>" class="btn btn-lg btn-secondary"><?=$action['text']?></a>
    			</p>
			<?php
		}
	?>
  </main>

</div>
	</body>
</html>
