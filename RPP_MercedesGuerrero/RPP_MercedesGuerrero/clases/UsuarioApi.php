<?php

class UsuarioApi extends Pizza implements IApiUsable{

    public function TraerUno($req, $res, $args){
        $id= $args['id'];
        $laPizza= Pizza::TraerUnaPizza($id);
        $newResponse= $response->withJson($laPizza, 200);

        return $newResponse;
    }

}

?>