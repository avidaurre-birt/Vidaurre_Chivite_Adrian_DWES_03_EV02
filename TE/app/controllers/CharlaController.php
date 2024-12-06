<?php

require '../app/models/Charla.php';

class CharlaController
{
    protected $id;
    protected $titulo;
    protected $fecha;
    protected $ubicacion;
    protected $duracion;
    protected $descripcion;
    protected $publico;

    protected $charlaModel;

    public function __construct()
    {
        $this->charlaModel = new Charla();
    }

    //GET
    public function getAll()
    {
        $charlas = $this->charlaModel->getAll();

        if ($charlas) {

            // Devuelve las charlaes con el código HTTP 200 (OK)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Lista de charlas obtenida con exito.");
            echo json_encode($charlas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            // Devuelve un mensaje de error con el código HTTP 500 (Internal Server Error)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_INTERNAL_SERVER_ERROR, "Error al obtener la lista de charlas.");
        }
    }

    //GET by ID
    public function getCharlaById($id)
    {
        $charla = $this->charlaModel->getCharlaById($id);

        if ($charla) {
            // Devuelve la Charla encontrada con el código HTTP 200 (OK)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Charla encontrada con exito.");
            echo (json_encode($charla, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } else {
            // Devuelve un mensaje de error con el código HTTP 404 (Not Found)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_NOT_FOUND, "No se encontro la Charla con el ID " . $id);
        }
    }

    //POST
    public function createCharla($data)
    {
        $nuevaCharla = $this->charlaModel->create($data);

        if ($nuevaCharla) {
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_CREATED, "Charla creada con exito.");
            echo json_encode($nuevaCharla, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            //Devuelve un mensaje de error con el código HTTP 400 (Bad Request)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_BAD_REQUEST, "Datos incompletos o incorrectos.");
        }
    }

    //PUT
    public function updateCharla($id, $data)
    {
        $charlaActualizada = $this->charlaModel->update($id, $data);

        if ($charlaActualizada) {
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Charla actualizada con exito.");
            echo json_encode($charlaActualizada, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            // Devuelve un mensaje de error con el código HTTP 400 (Bad Request)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_BAD_REQUEST,  "Datos incompletos o incorrectos.");
        }
    }

    //DELETE
    public function deleteCharla($id)
    {
        $charlaEliminada = $this->charlaModel->delete($id);

        if ($charlaEliminada) {
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Charla eliminada con exito.");
        } else {
            // Devuelve un mensaje de error con el código HTTP 404 (Not Found)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_NOT_FOUND, "No se encontro la charla con el ID " . $id);
        }
    }
}
