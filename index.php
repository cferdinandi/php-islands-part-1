<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>PHP Backend</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<style type="text/css">
			body {
				margin: 0 auto;
				max-width: 40em;
				width: 88%;
			}

			form [role="status"]:not(:empty) {
				background-color: #f7f7f7;
				border: 1px solid #e5e5e5;
				border-radius: 0.25em;
				margin-top: 1em;
				padding: 0.25em 0.5em;
			}
		</style>
	</head>

	<body>

		<h1>Your Items</h1>

		<?php

			include_once(dirname( __FILE__, 1) . '/api/helpers.php');

			// Reads a flat JSON file
			// returns an array of stuff
			// []
			$user_stuff = get_user_stuff();

			if (empty($user_stuff)) :

		?>

			<p><em>You have no stuff yet. Add an item to get started.</em></p>

		<?php else : ?>

			<p>Your items.</p>

			<ul>
				<?php foreach ($user_stuff as $key => $item) : ?>
				<li><?php echo htmlspecialchars($item); ?></li>
				<?php endforeach; ?>
			</ul>

		<?php endif; ?>



		<form action="./api/add-item.php" method="POST">

			<label for="item">The New Item</label>
			<input type="text" name="item" id="item" required>

			<input type="hidden" name="temp" value="this isn't real">

			<button>Add Item</button>

			<div role="status"><?php if (isset($_GET['message'])) : ?><?php echo htmlspecialchars($_GET['message']); ?><?php endif; ?></div>

		</form>
	</body>
</html>