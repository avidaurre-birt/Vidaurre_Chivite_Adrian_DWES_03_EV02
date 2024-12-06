<?php

class Limpieza
{
    protected $id;
    protected $ubicacion;
    protected $fecha;
    protected $cantidadRecogida;
    protected $participantes;
    protected $descripcion;



    public function __construct($id = null, $ubicacion = null, $fecha = null, $cantidadRecogida = null, $participantes = null, $descripcion = null)
    {
        $this->id = $id;
        $this->ubicacion = $ubicacion;
        $this->fecha = $fecha;
        $this->cantidadRecogida = $cantidadRecogida;
        $this->participantes = $participantes;
        $this->descripcion = $descripcion;
    }

    //GET
    public function getAll()
    {
        $info = file_get_contents('../data/limpiezas.json');

        return json_decode($info, true);
    }
    //GET by ID
    public function getById($id)
    {

        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        foreach ($limpiezas as $limpieza) {
            if ($limpieza['id'] === $id) {
                return $limpieza;
            }
        }
        return null;
    }
    //POST
    public function create($data)
    {

        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        $nuevoId = count($limpiezas) + 1;

        $nuevaLimpieza = [
            'id' => $nuevoId,
            'ubicacion' => $data['ubicacion'],
            'fecha' => $data['fecha'],
            'cantidadRecogida' => $data['cantidadRecogida'],
            'participantes' => $data['participantes'],
            'descripcion' => $data['descripcion'],
        ];

        $limpiezas[] = $nuevaLimpieza;
        //Guardamos el nuevo array de limpiezas en el archivo limpiezas.json
        file_put_contents('../data/limpiezas.json', json_encode($limpiezas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $nuevaLimpieza;
    }
    //PUT
    public function update($id, $data)
    {

        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        $limpiezaActualizada = null;

        //Buscamos la limpieza por id
        foreach ($limpiezas as $index => $limpieza) {
            if ($limpieza['id'] === $id) {

                //Actualizamos solo si introduce un nuevo valor
                $limpiezas[$index]['ubicacion'] = $data['ubicacion'] ?? $limpieza['ubicacion'];
                $limpiezas[$index]['fecha'] = $data['fecha'] ?? $limpieza['fecha'];
                $limpiezas[$index]['cantidadRecogida'] = $data['cantidadRecogida'] ?? $limpieza['cantidadRecogida'];
                $limpiezas[$index]['participantes'] = $data['participantes'] ?? $limpieza['participantes'];
                $limpiezas[$index]['descripcion'] = $data['descripcion'] ?? $limpieza['descripcion'];

                $limpiezaActualizada = $limpiezas[$index];
                break;
            }
        }
        if ($limpiezaActualizada) {
            file_put_contents('../data/limpiezas.json', json_encode($limpiezas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return $limpiezaActualizada;
        } else {
            return null;
        }
    }
    //DELETE
    public function delete($id)
    {

        $info = file_get_contents('../data/limpiezas.json');
        $limpiezas = json_decode($info, true);

        $limpiezaEliminada = false;

        foreach ($limpiezas as $index => $limpieza) {
            if ($limpieza['id'] === $id) {
                unset($limpiezas[$index]);

                $limpiezaEliminada = true;
                break;
            }
        }

        if ($limpiezaEliminada) {

            $limpiezas = array_values($limpiezas);

            file_put_contents('../data/limpiezas.json', json_encode($limpiezas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return $limpiezas;
        } else {
            return null;
        }
    }
}
