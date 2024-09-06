<?php
namespace App\components;
session_start();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Blog - Create Post</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	</head>
	<script>
	const createElement = (type, props = {}, ...children) => {
		const element = document.createElement(type);
		Object.assign(element, props);
		children.forEach(child => element.appendChild(child));
		return element;
	};

	const addCategory = () => {
		const categoryInput = document.getElementById('newCategory');
		const categoriesContainer = document.getElementById('categoriesContainer');
		const value = categoryInput.value.trim();

		if (value !== '') {
			const categoryDiv = createElement(
					'div', { className: 'input-group mb-2' },
					createElement('input', { 
					type: 'text', name: 'categories[]', className: 'form-control', value, readOnly: true 
				}),
					createElement('button', { 
					className: 'btn btn-danger', type: 'button', innerHTML: 'Delete', 
					onclick: e => categoriesContainer.removeChild(e.target.parentElement) 
				})
			);

			categoriesContainer.appendChild(categoryDiv);
			categoryInput.value = '';
		}
	};
	</script>

	<body>

		<?php require 'bar.php' ?>

		<h1>Create Post</h1>	

		<?php if(isset($_SESSION['user_id'])) : ?>

		<?php require 'create-post-form.php' ?>

		<?php else : ?>

		<form action="login.php">
			<p>You need to be logged first</p>
			<button type="submit" class="btn btn-light btn-outline-dark">Log in</button>
		</form>

		<?php endif; ?>

	</body>
</html>
