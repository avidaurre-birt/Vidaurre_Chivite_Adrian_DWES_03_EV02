<?php

require '../app/models/Limpieza.php';
class LimpiezaController
{
    protected $id;
    protected $ubicacion;
    protected $fecha;
    protected $cantidadRecogida;
    protected $participantes;
    protected $descripcion;



    public function __construct() {}

    //GET
    public function getAll()
    {
        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        if ($limpiezas) {

            // Devuelve las charlaes con el código HTTP 200 (OK)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Lista de limpiezas obtenida con exito.");
            echo json_encode($limpiezas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            // Devuelve un mensaje de error con el código HTTP 500 (Internal Server Error)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_INTERNAL_SERVER_ERROR, "Error al obtener la lista de limpiezas.");
        }
    }
    //GET by ID
    public function getLimpiezaById($id)
    {

        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        $limpiezaId = null;
        foreach ($limpiezas as $limpieza) {
            if ($limpieza['id'] === $id) {
                $limpiezaId = $limpieza;
                break;
            }
        }

        if ($limpiezaId) {

            // Devuelve la limpieza encontrada con el código HTTP 200 (OK)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Limpieza encontrada con exito.");
            echo (json_encode($limpiezaId, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } else {

            // Devuelve un mensaje de error con el código HTTP 404 (Not Found)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_NOT_FOUND, "No se encontro la limpieza con el ID " . $id);
        }
    }
    //POST
    public function createLimpieza($data)
    {

        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        $nuevoId = count($limpiezas) + 1;

        if (isset($data['ubicacion']) && isset($data['fecha']) && isset($data['cantidadRecogida']) && isset($data['participantes']) && isset($data['descripcion'])) {
            $limpiezas[] = [
                'id' => $nuevoId,
                'ubicacion' => $data['ubicacion'],
                'fecha' => $data['fecha'],
                'cantidadRecogida' => $data['cantidadRecogida'],
                'participantes' => $data['participantes'],
                'descripcion' => $data['descripcion'],
            ];

            //Guardamos el nuevo array de limpiezas en el archivo limpiezas.json
            file_put_contents('../data/limpiezas.json', json_encode($limpiezas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            HttpCodes::enviarRespuesta(HttpCodes::HTTP_CREATED, "Limpieza creada con exito.");
            echo json_encode($limpiezas[$nuevoId - 1], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {

            //Devuelve un mensaje de error con el código HTTP 400 (Bad Request)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_BAD_REQUEST, "Datos incompletos o incorrectos.");
        }
    }
    //PUT
    public function updateLimpieza($id, $data)
    {

        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        $limpiezaEncontrada = false;

        //Comprueba si se envia algun dato
        if (isset($data['ubicacion']) || isset($data['fecha']) || isset($data['cantidadRecogida']) || isset($data['participantes']) || isset($data['descripcion'])) {

            //Buscamos la limpieza por id
            foreach ($limpiezas as $limpieza) {
                if ($limpieza['id'] === $id) {

                    //Actualizamos solo si introduce un nuevo valor
                    if (empty($data['ubicacion'])) {
                        $data['ubicacion'] = $limpieza['ubicacion'];
                    }
                    if (empty($data['fecha'])) {
                        $data['fecha'] = $limpieza['fecha'];
                    }
                    if (empty($data['cantidadRecogida'])) {
                        $data['cantidadRecogida'] = $limpieza['cantidadRecogida'];
                    }
                    if (empty($data['participantes'])) {
                        $data['participantes'] = $limpieza['participantes'];
                    }
                    if (empty($data['descripcion'])) {
                        $data['descripcion'] = $limpieza['descripcion'];
                    }

                    $limpiezas[$id - 1] = [
                        'id' => $id,
                        'ubicacion' => $data['ubicacion'],
                        'fecha' => $data['fecha'],
                        'cantidadRecogida' => $data['cantidadRecogida'],
                        'participantes' => $data['participantes'],
                        'descripcion' => $data['descripcion']
                    ];

                    $limpiezaEncontrada = true;

                    file_put_contents('../data/limpiezas.json', json_encode($limpiezas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                    HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Limpieza actualizada con exito.");
                    echo json_encode($limpiezas[$id - 1], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
            }
            if (!$limpiezaEncontrada) {

                // Devuelve un mensaje de error con el código HTTP 404 (Not Found)
                HttpCodes::enviarRespuesta(HttpCodes::HTTP_NOT_FOUND, "No se encontro la limpieza con ID $id.");
            }
        } else {
            // Devuelve un mensaje de error con el código HTTP 400 (Bad Request)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_BAD_REQUEST,  "Datos incompletos o incorrectos.");
        }
    }
    //DELETE
    public function deleteLimpieza($id)
    {

        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        $limpiezaEncontrada = false;

        foreach ($limpiezas as $limpieza) {
            if ($limpieza['id'] === $id) {
                unset($limpiezas[$id - 1]);

                $limpiezaEncontrada = true;
                break;
            }
        }

        if ($limpiezaEncontrada) {

            $limpiezas = array_values($limpiezas);

            file_put_contents('../data/limpiezas.json', json_encode($limpiezas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "limpieza eliminada con exito.");
        } else {
            // Devuelve un mensaje de error con el código HTTP 404 (Not Found)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_NOT_FOUND, "No se encontro la limpieza con el ID " . $id);
        }
    }
}
