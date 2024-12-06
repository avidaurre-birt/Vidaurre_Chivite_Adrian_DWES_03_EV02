<?php

class Plantacion
{

    protected $id;
    protected $ubicacion;
    protected $fecha;
    protected $arboles;
    protected $participantes;


    public function __construct($id = null, $ubicacion = null, $fecha = null, $arboles = null, $participantes = null)
    {
        $this->id = $id;
        $this->ubicacion = $ubicacion;
        $this->fecha = $fecha;
        $this->arboles = $arboles;
        $this->participantes = $participantes;
    }

    //GET
    public function getAll()
    {
        $info = file_get_contents('../data/plantaciones.json');

        return json_decode($info, true);
    }
    //GET by ID
    public function getById($id)
    {

        $info = file_get_contents('../data/plantaciones.json');
        $plantaciones = json_decode($info, true);

        foreach ($plantaciones as $plantacion) {
            if ($plantacion['id'] === $id) {
                return $plantacion;
            }
        }
        return null;
    }
    //POST
    public function create($data)
    {

        $info = file_get_contents('../data/plantaciones.json');
        $plantaciones = json_decode($info, true);

        $nuevoId = count($plantaciones) + 1;

        $nuevaPlantacion = [
            'id' => $nuevoId,
            'ubicacion' => $data['ubicacion'],
            'fecha' => $data['fecha'],
            'arboles' => $data['arboles'],
            'participantes' => $data['participantes']
        ];
        $plantaciones[] = $nuevaPlantacion;
        //Guardamos el nuevo array de plantaciones en el archivo plantaciones.json
        file_put_contents('../data/plantaciones.json', json_encode($plantaciones, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $nuevaPlantacion;
    }
    //PUT
    public function update($id, $data)
    {

        $info = file_get_contents('../data/plantaciones.json');
        $plantaciones = json_decode($info, true);

        $plantacionActualizada = null;

        //Buscamos la plantacion por id
        foreach ($plantaciones as $index => $plantacion) {
            if ($plantacion['id'] === $id) {

                //Actualizamos solo si introduce un nuevo valor
                $plantaciones[$index]['ubicacion'] = $data['ubicacion'] ?? $plantacion['ubicacion'];
                $plantaciones[$index]['fecha'] = $data['fecha'] ?? $plantacion['fecha'];
                $plantaciones[$index]['arboles'] = $data['arboles'] ?? $plantacion['arboles'];
                $plantaciones[$index]['participantes'] = $data['participantes'] ?? $plantacion['participantes'];

                $plantacionActualizada = $plantaciones[$index];
                break;
            }
        }
        if ($plantacionActualizada) {
            file_put_contents('../data/plantaciones.json', json_encode($plantaciones, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return $plantacionActualizada;
        } else {
            return null;
        }
    }
    //DELETE
    public function delete($id)
    {
        $info = file_get_contents('../data/plantaciones.json');
        $plantaciones = json_decode($info, true);

        $plantacionEliminada = false;

        foreach ($plantaciones as $index => $plantacion) {
            if ($plantacion['id'] === $id) {
                unset($plantaciones[$index]);

                $plantacionEliminada = true;
                break;
            }
        }
        if ($plantacionEliminada) {

            $plantaciones = array_values($plantaciones);

            file_put_contents('../data/plantaciones.json', json_encode($plantaciones, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return $plantaciones;
        } else {
            return null;
        }
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of ubicacion
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set the value of ubicacion
     */
    public function setUbicacion($ubicacion): self
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha($fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of arboles
     */
    public function getArboles()
    {
        return $this->arboles;
    }

    /**
     * Set the value of arboles
     */
    public function setArboles($arboles): self
    {
        $this->arboles = $arboles;

        return $this;
    }

    /**
     * Get the value of participantes
     */
    public function getParticipantes()
    {
        return $this->participantes;
    }

    /**
     * Set the value of participantes
     */
    public function setParticipantes($participantes): self
    {
        $this->participantes = $participantes;

        return $this;
    }
}
