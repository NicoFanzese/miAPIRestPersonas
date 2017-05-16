<?php

	use \Psr\Http\Message\ServerRequestInterface as Request;
	use \Psr\Http\Message\ResponseInterface as Response;
	require '/vendor/autoload.php';
	require '/clases/AccesoDatos.php';
	require '/clases/Persona.php';

	$app = new \Slim\App;
	//Función de prueba
	$app->get('/hello/{name}', function ($request, $response, $arg) {
	    $name = $request->getAttribute('name');
	    $response->getBody()->write("Hello, $name");

	    return $response;
	});

	$app->get('/usuarios[/]', function ($request, $response, $args) {
			//Traigo a todos los usuarios
    		$listado=Usuario::TraerTodosLosUsuarios();
			//Envío el listado de usuarios por json
    		return $response->write(json_encode($listado));
		});

	$app->delete('/usuarios/{id}', function ($request, $response, $arg) {
		//Recibo el id a eliminar por parametro
	    $id = json_decode($arg['id']);
		//Busco el usuario mediante el id
	    $usuarioBorrado = Usuario::TraerUnUsuario($id); 
		//Si no se encontró grabo un mensaje
	    if($usuarioBorrado == false)
	    {
	    	$response->write("Usuario no encontrado");
	    }
	    else
	    {
			//Sino borro el usuario y envio los datos 
	    	Usuario::Borrar($id);
	    	$response->write(json_encode($usuarioBorrado));
	    }

	    return $response;

	});

	$app->post('/usuarios[/]', function ($request, $response, $arg) {
		//Recibo los datos, creo un usuario nuevo y le asigno los valores
	    $datosRecibidos = $request->getQueryParams();
	    $usuario = new Usuario();
	    $usuario->usuario = $datosRecibidos['usuario'];
	    $usuario->password = $datosRecibidos['password'];
		//Inserto el usuario nuevo
	    Usuario::Insertar($usuario);
		//Retorno en json el nuevo usuario
	    return $response->write(json_encode($usuario));
	});

	$app->put('/usuarios[/]', function ($request, $response, $arg) {
		//Recibo los datos y los asigno a un nuevo usuario
	    $datosRecibidos = $request->getQueryParams();
	    $usuario = new Usuario();
	    $usuario->id = $datosRecibidos['id'];
	    $usuario->usuario = $datosRecibidos['usuario'];
	    $usuario->password = $datosRecibidos['password'];
		//Llamo a la funcion Moficar y le paso los nuevos datos a modificar segun id
	    Usuario::Modificar($usuario);
		//Devuelvo el usuario modificado en json
	    return $response->write(json_encode($usuario));
	});

	$app->get('/login[/]', function ($request, $response, $arg) {
		//Los datos que recibo los meto en $datosRecibidos
	    $datosRecibidos = $request->getQueryParams();
		//Creo un nuevo usuario y le asigno los datos recibidos
	    $usuario = new Usuario();
	    $usuario->usuario = $datosRecibidos['usuario'];
	    $usuario->password = $datosRecibidos['password'];
		//Llamo a el método que busca si el usuario y la contraseña existen, devuelve true or false
	    $estaRegistrado = Usuario::EstaRegistrado($usuario);
		//Devuelvo el mensaje (true o false) encodeado a json
	    return $response->write(json_encode($estaRegistrado));
	});

	$app->run();
?>