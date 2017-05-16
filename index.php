<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require './clases/AccesoDatos.php';
require './clases/Persona.php';



$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");
    return $response;
});
//-- metodo default
$app->get('/', function (Request $request, Response $response) {
    //$name = $request->getAttribute('name');
    $response->getBody()->write("Hola mundo!!");
    return $response;
});
// -- metodo traer todas las personas
$app->get('/personas[/]', function (Request $request, Response $response) {
	$Listado = Persona::TraerTodasLasPersonas();
	$listadoEncodeadoEnJson = json_encode($Listado);
    $response->write($listadoEncodeadoEnJson);
    return $response;
});
// -- metodo traer una persona por id
$app->get('/persona[/]', function ($request, $response, $args) {
	$datosPost = $request->getQueryParams(); //tomo lo que le mande por parametro y lo parse a php
    $unaPersona = Persona::TraerUnaPersona($datosPost['id']);
    $unaPersonaEncodeadaEnJson = json_encode($unaPersona);
    $response->write($unaPersonaEncodeadaEnJson);
    return $response;
});
// -- metodo recibe una parsona y da de alta
$app->post('/persona[/]', function ($request, $response, $args) {
	$datosPost = $request->getQueryParams(); //tomo lo que le mande por parametro y lo parse a php
    //armo el objeto persona
    $unaPersona = new Persona();
    $unaPersona->nombre = $datosPost['nombre'];
    $unaPersona->apellido = $datosPost['apellido'];
    $unaPersona->dni = $datosPost['dni'];
    Persona::InsertarPersona($unaPersona);
    $response->write("Persona insertada con exito -->");
    return $response;
});
// -- metodo borrar una persona por id
$app->delete('/persona/{id}', function ($request, $response, $args) {
	$datosPost = json_decode($args["id"]); //tomo lo que le mande por parametro y lo parse a php
    Persona::BorrarPersona($datosPost->id);
    $response->write("Persona Borrada con exito");
    //  $response->write(json_encode($datosPost));
    return $response;
});
// -- metodo recibe una parsona y la modifica
$app->put('/persona/{persona}', function ($request, $response, $args) {
    //$datosPost = $request->getQueryParams(); //tomo lo que le mande por parametro y lo parse a php
    $datosPost = json_decode($args["persona"]); //tomo lo que le mande por parametro y lo parse a php
    // //armo el objeto persona
    $unaPersona = new Persona();
    $unaPersona->id = $datosPost->id;
    $unaPersona->nombre = $datosPost->nombre;
    $unaPersona->apellido = $datosPost->apellido;
    $unaPersona->dni = $datosPost->dni;
    Persona::ModificarPersona($unaPersona); // modifico la persona
    $response->write("Persona modificada con exito");
    //$response->write(json_encode($datosPost));
    return $response;
});
$app->run();
?>