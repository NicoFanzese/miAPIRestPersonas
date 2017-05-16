<?php
require_once"AccesoDatos.php";
class usuario
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
	public $usuario;
 	public $password;
//--------------------------------------------------------------------------------//
//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	public function Getpassword()
	{
		return $this->password;
	}
	public function GetUsuario()
	{
		return $this->usuario;
	}
	public function SetId($valor)
	{
		$this->id = $valor;
	}
	public function Setpassword($valor)
	{
		$this->password = $valor;
	}
	public function SetUsuario($valor)
	{
		$this->usuario = $valor;
	}

//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($dni=NULL)
	{
		if($dni != NULL){
			$obj = usuario::TraerUnUsuario($dni);
			
			$this->password = $obj->password;
			$this->usuario = $obj->usuario;
		}
	}
//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->password."-".$this->usuario;
	}
//--------------------------------------------------------------------------------//
//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUnUsuario($idParametro) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario where id =:id");
        //$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerUnUsuario(:id)");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$usuarioBuscada= $consulta->fetchObject('usuario');
		return $usuarioBuscada;						
	}
	
	public static function TraerTodosLosUsuarios()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario");
		$consulta->execute();			
		$arrusuarios= $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");	
		return $arrusuarios;
	}
	
	public static function Borrar($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from usuario	WHERE id=:id");		
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}
	
	public static function Modificar($usuario)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			
			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuario set usuario=:usuario,password=:password WHERE id=:id");
			$consulta->bindValue(':id',$usuario->id, PDO::PARAM_INT);
			$consulta->bindValue(':usuario',$usuario->usuario, PDO::PARAM_STR);
			$consulta->bindValue(':password', $usuario->password, PDO::PARAM_STR);
			return $consulta->execute();
	}
//--------------------------------------------------------------------------------//
//--------------------------------------------------------------------------------//
	public static function Insertar($usuario)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (usuario,password)values(:usuario,:password)");
        //$consulta =$objetoAccesoDato->RetornarConsulta("CALL Insertarusuario (:usuario,:password,:dni,:foto)");
		$consulta->bindValue(':usuario',$usuario->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':password', $usuario->password, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	

	public static function EstaRegistrado($usuario) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario where usuario = :usuario and password = :password");
        //$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerUnUsuario(:id)");
		$consulta->bindValue(':usuario', $usuario->usuario, PDO::PARAM_STR);
		$consulta->bindValue(':password', $usuario->password, PDO::PARAM_STR);
		$consulta->execute();
		$usuarioBuscado= $consulta->fetchObject('usuario');

		if($usuarioBuscado != false)
			$usuarioBuscado = true;

		return $usuarioBuscado;						
	}

}