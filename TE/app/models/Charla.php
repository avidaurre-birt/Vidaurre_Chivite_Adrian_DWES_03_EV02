<?php

class Charla
{
    protected $id;
    protected $titulo;
    protected $fecha;
    protected $ubicacion;
    protected $duracion;
    protected $descripcion;
    protected $publico;


    public function __construct($id = null, $titulo = null, $fecha = null, $ubicacion = null, $duracion = null, $descripcion = null)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->fecha = $fecha;
        $this->ubicacion = $ubicacion;
        $this->duracion = $duracion;
        $this->descripcion = $descripcion;
    }

    //GET
    public function getAll()
    {
        $info = file_get_contents('../data/charlas.json');
        return json_decode($info, true);
    }

    //GET by ID
    public function getCharlaById($id)
    {
        $data = file_get_contents('../data/charlas.json');
        $charlas = json_decode($data, true);

        foreach ($charlas as $charla) {
            if ($charla['id'] === $id) {
                return $charla;
                break;
            }
        }
        return null;
    }

    //POST
    public function create($data)
    {
        $info = file_get_contents('../data/charlas.json');
        $charlas = json_decode($info, true);

        $nuevoId = count($charlas) + 1;


        $nuevaCharla = [
            'id' => $nuevoId,
            'titulo' => $data['titulo'],
            'fecha' => $data['fecha'],
            'ubicacion' => $data['ubicacion'],
            'duracion' => $data['duracion'],
            'descripcion' => $data['descripcion']
        ];

        $charlas[] = $nuevaCharla;
        //Guardamos el nuevo array de Charlas en el archivo charlas.json
        file_put_contents('../data/charlas.json', json_encode($charlas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $nuevaCharla;
    }

    //PUT
    public function update($id, $data)
    {
        $info = file_get_contents('../data/charlas.json');
        $charlas = json_decode($info, true);

        $charlaActualizada = null;

        //Buscamos la charla por id
        foreach ($charlas as $index => $charla) {
            if ($charla['id'] === $id) {

                //Actualizamos solo si introduce un nuevo valor
                $charlas[$index]['titulo'] = $data['titulo'] ?? $charla['titulo'];
                $charlas[$index]['fecha'] = $data['fecha'] ?? $charla['fecha'];
                $charlas[$index]['ubicacion'] = $data['ubicacion'] ?? $charla['ubicacion'];
                $charlas[$index]['duracion'] = $data['duracion'] ?? $charla['duracion'];
                $charlas[$index]['descripcion'] = $data['descripcion'] ?? $charla['descripcion'];

                $charlaActualizada = $charlas[$index];
                break;
            }
        }
        if ($charlaActualizada) {

            file_put_contents('../data/charlas.json', json_encode($charlas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return $charlaActualizada;
        } else {
            return null;
        }
    }

    //DELETE
    public function delete($id)
    {
        $info = file_get_contents('../data/charlas.json');
        $charlas = json_decode($info, true);

        $charlaEliminada = false;

        foreach ($charlas as $index => $charla) {
            if ($charla['id'] === $id) {
                unset($charlas[$index]);

                $charlaEliminada = true;
                break;
            }
        }

        if ($charlaEliminada) {
            $charlas = array_values($charlas);

            file_put_contents('../data/charlas.json', json_encode($charlas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return $charlas;
        } else {
            return null;
        }
    }
}
