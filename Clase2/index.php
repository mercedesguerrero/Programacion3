
<?php 

	//aca se crean los objetos, es como el main
	require_once "Conteiner.php";
	require_once "Producto.php";

	$conteiner1= new Conteiner(1, 1000, "chico");

	$producto1= new Producto(1, "Remeras", "ImpArg", "China", 400);
	$producto2= new Producto(2, "Pantalones", "LaImp", "EEUU", 700);
	$producto3= new Producto(3, "Zapatillas", "ExportArg", "Taiwan", 450);

	$conteiner1->AgregarProducto($producto1);
	$conteiner1->AgregarProducto($producto2);
	$conteiner1->AgregarProducto($producto3);

	$conteiner1->MostrarContenido();



 ?>