<?php

namespace Parzibyte\Servicios;

use Parzibyte\Modelos\ModeloUsuarios;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;

class Twig
{

    public static function obtener()
    {
        $cachearTwig = boolval(Comun::env("HABILITAR_CACHE_TWIG", false));
        $rutaCacheTwig = false;
        if ($cachearTwig) {
            $rutaCacheTwig = Comun::env("RUTA_CACHE_TWIG", "cache_twig");
        }
        $loader = new FilesystemLoader(DIRECTORIO_RAIZ . "/vistas");
        $twig = new Environment($loader, [
            "cache" => $rutaCacheTwig,
        ]);
        $twig->addGlobal("URL_DIRECTORIO_PUBLICO", URL_DIRECTORIO_PUBLICO);
        $twig->addGlobal("RUTA_API", RUTA_API);
        $twig->addGlobal("URL_RAIZ", URL_RAIZ);
        $twig->addGlobal("NOMBRE_APLICACION", NOMBRE_APLICACION);
        $twig->addGlobal("AUTOR", AUTOR);
        $twig->addGlobal("WEB_AUTOR", WEB_AUTOR);
        $twig->addGlobal("TIEMPO_ACTUAL", time());
        $twig->addGlobal("USUARIO_LOGUEADO", SesionService::leer("correoUsuario"));
        $usuario = ModeloUsuarios::uno(SesionService::leer("idUsuario"));
        $twig->addGlobal("USUARIO_ADMIN", $usuario != null && $usuario->administrador);
        $twig->addFunction(new TwigFunction("sesion_flash", function ($clave) {
            return SesionService::flash($clave);
        }));
        $twig->addFunction(new TwigFunction("token_csrf", function () {
            return Seguridad::obtenerTokenCSRF();
        }));
        return $twig;
    }
}
