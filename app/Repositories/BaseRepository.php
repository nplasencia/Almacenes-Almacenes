<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{

    /**
     * @return \App\Entities\Entity
     */
    abstract public function getEntity();

    /**
     * Este método se utiliza para que no se utilice el método mágico y se incluya el newQuery() que se llamará.
     * Básicamente, ayuda a que el código quede más limpio sin que el IDE nos marque errores.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return $this->getEntity()->newQuery();
    }

    public function findOrFail($id)
    {
        return $this->newQuery()->findOrFail($id);
    }

    public function create(Array $elements)
    {
        return $this->getEntity()->create($elements);
    }

    public function delete(Model $item)
    {
        $item->delete();
        return $item;
    }

    public function deleteById($id)
    {
        $item = $this->findOrFail($id);
        return $this->delete($item);
    }
}