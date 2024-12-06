<?php
require '../app/models/Plantacion.php';

class PlantacionController
{

    protected $plantacionModel;

    public function __construct()
    {
        $this->plantacionModel = new Plantacion();
    }

    //GET
    public function getAll()
    {
        $plantaciones = $this->plantacionModel->getAll();

        if ($plantaciones) {

            // Devuelve las charlaes con el código HTTP 200 (OK)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Lista de plantaciones obtenida con exito.");
            echo json_encode($plantaciones, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            // Devuelve un mensaje de error con el código HTTP 500 (Internal Server Error)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_INTERNAL_SERVER_ERROR, "Error al obtener la lista de plantaciones.");
        }
    }
    //GET by ID
    public function getPlantacionById($id)
    {
        $plantacion = $this->plantacionModel->getById($id);

        if ($plantacion) {

            // Devuelve la plantacion encontrada con el código HTTP 200 (OK)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Plantacion encontrada con exito.");
            echo (json_encode($plantacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } else {

            // Devuelve un mensaje de error con el código HTTP 404 (Not Found)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_NOT_FOUND, "No se encontro la plantacion con el ID " . $id);
        }
    }
    //POST
    public function createPlantacion($data)
    {
        $nuevaPlantacion = $this->plantacionModel->create($data);

        if ($nuevaPlantacion) {
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_CREATED, "Plantacion creada con exito.");
            echo json_encode($nuevaPlantacion, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {

            //Devuelve un mensaje de error con el código HTTP 400 (Bad Request)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_BAD_REQUEST, "Datos incompletos o incorrectos.");
        }
    }
    //PUT
    public function updatePlantacion($id, $data)
    {
        $plantacionActualizada = $this->plantacionModel->update($id, $data);

        if ($plantacionActualizada) {
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Plantacion actualizada con exito.");
            echo json_encode($plantacionActualizada, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            // Devuelve un mensaje de error con el código HTTP 400 (Bad Request)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_BAD_REQUEST,  "Datos incompletos o incorrectos.");
        }
    }
    //DELETE
    public function deletePlantacion($id)
    {
        $plantacionBorrada = $this->plantacionModel->delete($id);

        if ($plantacionBorrada) {

            HttpCodes::enviarRespuesta(HttpCodes::HTTP_OK, "Plantacion eliminada con exito.");
        } else {
            // Devuelve un mensaje de error con el código HTTP 404 (Not Found)
            HttpCodes::enviarRespuesta(HttpCodes::HTTP_NOT_FOUND, "No se encontro la plantacion con el ID " . $id);
        }
    }
}
