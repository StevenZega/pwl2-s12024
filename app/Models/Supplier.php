<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';

    public function get_supplier(){
        $sql = $this->select("*");

        return $sql;
    }
}
