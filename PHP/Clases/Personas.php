<?php
require_once"AccesoDatos.php";
class Persona
{
//--------------------------------------------------------------------------------//
//--ATRIBUTOS
	public $id;
	public $nombre;
 	public $apellido;
  	public $dni;
  	public $foto;		
        public $sexo;  	
        public $password;

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--GETTERS Y SETTERS
  	public function GetId()
	{
		return $this->id;
	}
	public function GetApellido()
	{
		return $this->apellido;
	}
	public function GetNombre()
	{
		return $this->nombre;
	}
	public function GetDni()
	{
		return $this->dni;
	}
	public function GetFoto()
	{
		return $this->foto;
	}
	public function GetSexo()	{		return $this->sexo;	}			
        public function GetPassword()	{		return $this->password;	}
	public function SetId($valor)
	{
		$this->id = $valor;
	}
	public function SetApellido($valor)
	{
		$this->apellido = $valor;
	}
	public function SetNombre($valor)
	{
		$this->nombre = $valor;
	}
	public function SetDni($valor)
	{
		$this->dni = $valor;
	}
	public function SetFoto($valor)
	{
		$this->foto = $valor;
	}		
        public function SetSexo($valor)	{		$this->sexo = $valor;	}			
        public function SetPassword($valor)	{		$this->password = $valor;	}
//--------------------------------------------------------------------------------//
//--CONSTRUCTOR
	public function __construct($dni=NULL)
	{
		if($dni != NULL){
			$obj = Persona::TraerUnaPersona($dni);			
			$this->apellido = $obj->apellido;
			$this->nombre = $obj->nombre;
			$this->dni = $dni;
			$this->foto = $obj->foto;						
                        $this->sexo = $obj->sexo;						
                        $this->password = $obj->password;
		}
	}

//--------------------------------------------------------------------------------//
//--TOSTRING	
  	public function ToString()
	{
	  	return $this->apellido."-".$this->nombre."-".$this->dni."-".$this->foto."-".$this->sexo;
	}
//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//
//--METODO DE CLASE
	public static function TraerUnaPersona($idParametro) 
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from persona where id =:id");
        //$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerUnaPersona(:id)");
		$consulta->bindValue(':id', $idParametro, PDO::PARAM_INT);
		$consulta->execute();
		$personaBuscada= $consulta->fetchObject('persona');
		return $personaBuscada;						
	}
	
	public static function TraerTodasLasPersonas()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from persona");
		//$consulta =$objetoAccesoDato->RetornarConsulta("CALL TraerTodasLasPersonas() ");
		$consulta->execute();			
		$arrPersonas= $consulta->fetchAll(PDO::FETCH_CLASS, "persona");	
		return $arrPersonas;
	}
	
	public static function BorrarPersona($idParametro)
	{	
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("delete from persona	WHERE id=:id");	
        //$consulta =$objetoAccesoDato->RetornarConsulta("CALL BorrarPersona(:id)");	
		$consulta->bindValue(':id',$idParametro, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
		
	}
	
	public static function ModificarPersona($persona)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			/*$consulta =$objetoAccesoDato->RetornarConsulta("
				update persona 
				set nombre=:nombre,
				apellido=:apellido,
				foto=:foto
				WHERE id=:id");
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();*/ 
			//$consulta =$objetoAccesoDato->RetornarConsulta("CALL ModificarPersona(:dni,:nombre,:apellido,:foto)");
			$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE persona set dni=:dni,nombre=:nombre,apellido=:apellido,foto=:foto,sexo=:sexo,password=:password WHERE id=:id");
			$consulta->bindValue(':id',$persona->id, PDO::PARAM_INT);
			$consulta->bindValue(':dni',$persona->dni, PDO::PARAM_STR);
			$consulta->bindValue(':nombre',$persona->nombre, PDO::PARAM_STR);
			$consulta->bindValue(':apellido', $persona->apellido, PDO::PARAM_STR);
			$consulta->bindValue(':foto', $persona->foto, PDO::PARAM_STR);						$consulta->bindValue(':sexo', $persona->sexo, PDO::PARAM_STR);						$consulta->bindValue(':password', $persona->password, PDO::PARAM_STR);
			return $consulta->execute();
	}

//--------------------------------------------------------------------------------//

//--------------------------------------------------------------------------------//

	public static function InsertarPersona($persona)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into persona (nombre,apellido,dni,foto, sexo, password)values(:nombre,:apellido,:dni,:foto, :sexo, :password)");
        //$consulta =$objetoAccesoDato->RetornarConsulta("CALL InsertarPersona (:nombre,:apellido,:dni,:foto)");
		$consulta->bindValue(':nombre',$persona->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':apellido', $persona->apellido, PDO::PARAM_STR);
		$consulta->bindValue(':dni', $persona->dni, PDO::PARAM_STR);
		$consulta->bindValue(':foto', $persona->foto, PDO::PARAM_STR);				$consulta->bindValue(':sexo', $persona->sexo, PDO::PARAM_STR);				$consulta->bindValue(':password', $persona->password, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	
				
	}	
//--------------------------------------------------------------------------------//



	public static function TraerPersonasTest()
	{
		$arrayDePersonas=array();

		$persona = new stdClass();
		$persona->id = "4";
		$persona->nombre = "rogelio";
		$persona->apellido = "agua";
		$persona->dni = "333333";
		$persona->foto = "333333.jpg";				$persona->sexo = "Masculino";				$persona->password = "123456";

		//$objetJson = json_encode($persona);
		//echo $objetJson;
		$persona2 = new stdClass();
		$persona2->id = "5";
		$persona2->nombre = "Bañera";
		$persona2->apellido = "giratoria";
		$persona2->dni = "222222";
		$persona2->foto = "222222.jpg";				$persona2->sexo = "Femenino";				$persona2->password = "123456";

		$persona3 = new stdClass();
		$persona3->id = "6";
		$persona3->nombre = "Julieta";
		$persona3->apellido = "Roberto";
		$persona3->dni = "888888";
		$persona3->foto = "888888.jpg";				$persona3->sexo = "Femenino";				$persona3->password = "123456";

		$arrayDePersonas[]=$persona;
		$arrayDePersonas[]=$persona2;
		$arrayDePersonas[]=$persona3;
		 
		return  $arrayDePersonas;
	}	
}
