<?php

namespace Model;

class Usuario extends ActiveRecord{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? null;
        $this->password_actual = $args['password_actual'] ?? null;
        $this->password_nuevo = $args['password_nuevo'] ?? null;
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][]= 'El "Nombre" del usuario es obligatorio.';
        }

        if (!$this->email) {
            self::$alertas['error'][]= 'El "Email" del usuario es obligatorio.';
        }

        if (!$this->password) {
            self::$alertas['error'][]= 'El "Password" no puede ir vacio.';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][]= 'El "Password" debe tener al menos 6 caracteres.';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][]= 'El Password no coincide';
        }

        return self::$alertas;
    }

    // Validar el Login de Usuarios
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][]= 'El "Email" del usuario es obligatorio.';
        }
        
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email NO valido';
        }

        if (!$this->password) {
            self::$alertas['error'][]= 'El "Password" no puede ir vacio.';
        }

        return self::$alertas;

    }

    // Hashea el password
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);  
    }

    public function comprobar_password(): bool
    {
        return password_verify($this->password_actual,  $this->password);
    }

    // Generar un Token
    public function crearToken(): void
    {
        $this->token = uniqid();
    }

    // Validar un email
    public function validarEmail()
    {
        if (!$this->email) {// Si esta vacio
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email NO valido';
        }

        return self::$alertas;
    }

    // Validar el Password
    public function validarPassword(){
        
        if (strlen($this->password) < 6) {
            self::$alertas['error'][]= 'El "Password" debe tener al menos 6 caracteres.';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][]= 'El Password no coincide';
        }

        return self::$alertas;
    }

    public function validarPerfil()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }

        return self::$alertas;
    }

    public function nuevo_password() : array
    {
        if (!$this->password_actual) {
            self::$alertas['error'][] = 'El Password Actual no puede ir vacio.';
        }
        if (!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio.';
        }
        if (strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres.';
        }

        return self::$alertas;
    }

}

?>