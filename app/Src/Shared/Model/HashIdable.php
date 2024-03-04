<?php

namespace App\Src\Shared\Model;

use Vinkla\Hashids\Facades\Hashids;

trait HashIdable
{

    public function resolveRouteBinding($value, $field = null)
    {
        if (is_null($field)) {
            $field = 'id';
        }

        $id = $value;
        if ($this->urlHasheable()) {
            $id = $this->decode($value);
        }

        return $this->where($field, $id)->withTrashed()->firstOrFail();
    }

    public function hashId()
    {
        if ($this->urlHasheable()) {
            return Hashids::encode($this->id);
        }

        return $this->id;
    }

    public function buildHash($valor)
    {
        return Hashids::encode($valor);
    }

    public function decode($parameter)
    {
        if ($this->urlHasheable()){
            $valor = Hashids::decode($parameter);

            if (isset($valor[0])) {
                return $valor[0];
            }

            if (is_numeric($parameter)){
                return $parameter;
            }

            throw new \InvalidArgumentException(sprintf('Could not decode the following value: %s', $parameter));
        }

        return $parameter;

    }

    private function urlHasheable()
    {
        return config('linguameeting.url_hasheable');
    }
}
