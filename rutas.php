<?php

use Parzibyte\Servicios\SesionService;
use Parzibyte\Redirect;
use Phroute\Phroute\RouteCollector;
$enrutador = new RouteCollector();

$enrutador->filter("logueado", function () {
    if (empty(SesionService::leer("correoUsuario"))) {
        return Redirect::to("/login")->do();
    }
});

$enrutador->filter("administrador", function () {
    if (!SesionService::leer("administrador") || !SesionService::leer("idUsuario")) {
        # NOTA: aquí haz la redirección a donde el usuario deba ir
        return Redirect::to("/perfil/cambiar-password")->do();
    }
});

$enrutador
    ->group(["before" => "logueado"], function ($enrutadorVistasPrivadas) {
        $enrutadorVistasPrivadas
            ->get("/perfil/cambiar-password", ["Parzibyte\Controladores\ControladorUsuarios", "perfilCambiarPassword"])
            ->post("/perfil/cambiar-password", ["Parzibyte\Controladores\ControladorUsuarios", "perfilGuardarPassword"])
            ->get("/logout", ["Parzibyte\Controladores\ControladorLogin", "logout"]);
    });

$enrutador
    ->group(["before" => "administrador"], function ($enrutadorVistasPrivadas) {
        $enrutadorVistasPrivadas
            ->get("/ajustes", ["Parzibyte\Controladores\ControladorAjustes", "index"])
            ->get("/usuarios", ["Parzibyte\Controladores\ControladorUsuarios", "index"])
            ->get("/usuarios/agregar", ["Parzibyte\Controladores\ControladorUsuarios", "agregar"])
            ->post("/usuarios/eliminar", ["Parzibyte\Controladores\ControladorUsuarios", "eliminar"])
            ->get("/usuarios/eliminar/{idUsuario}", ["Parzibyte\Controladores\ControladorUsuarios", "confirmarEliminacion"])
            ->post("/usuarios/guardar", ["Parzibyte\Controladores\ControladorUsuarios", "guardar"]);
    });

$enrutador->post("/login", ["Parzibyte\Controladores\ControladorLogin", "login"]);
$enrutador->get("/login", ["Parzibyte\Controladores\ControladorLogin", "index"]);
$enrutador->get("/registro", ["Parzibyte\Controladores\ControladorUsuarios", "registrar"]);
$enrutador->post("/usuarios/registro", ["Parzibyte\Controladores\ControladorUsuarios", "registro"]);

$enrutador->get("/usuarios/verificar/{token}", ["Parzibyte\Controladores\ControladorUsuarios", "verificar"]);
# Cuando quieren resetear
$enrutador->get("/usuarios/solicitar-nueva-password", ["Parzibyte\Controladores\ControladorUsuarios", "formularioSolicitarNuevaPassword"]);
$enrutador->post("/usuarios/solicitar-nueva-password", ["Parzibyte\Controladores\ControladorUsuarios", "solicitarNuevaPassword"]);
# Cuando ya les llegó el correo
$enrutador->get("/usuarios/restablecer-password/{token}", ["Parzibyte\Controladores\ControladorUsuarios", "formularioRestablecerPassword"]);
$enrutador->post("/usuarios/restablecer-password", ["Parzibyte\Controladores\ControladorUsuarios", "restablecerPassword"]);
# Reenviar correo de registro
$enrutador->get("/usuarios/reenviar-correo", ["Parzibyte\Controladores\ControladorUsuarios", "solicitarReenvioCorreo"]);
$enrutador->post("/usuarios/reenviar-correo", ["Parzibyte\Controladores\ControladorUsuarios", "reenviarCorreo"]);

$enrutador->get("/", ["Parzibyte\Controladores\ControladorLogin", "index"]);

return $enrutador;