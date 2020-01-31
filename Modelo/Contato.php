<?php 

class contato{

private $id_contato;
private $id_usuario;
private $motivo;
private $mensagem;


public function __construct() {
    if (func_num_args() != 0) {
        $atributos = func_get_args()[0];
        foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }

    function atualizar($vetor) {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }

     public function getId_contato(){
         return $this->id_contato;
     }

     function setId_contato($id_contato){
          $this->id_contato = $id_contato;
     }

     public function getId_usuario(){
         return $this->id_usuario;
     }

     function setId_usuario($id_usuario){
          $this->id_usuario = $id_usuario;
     }

     public function getMotivo(){
         return $this->motivo;
     }

     function setMotivo($motivo){
          $this->motivo = $motivo;
     }

     public function getMensagem(){
         return $this->mensagem;
     }

     function setMensagem($mensagem){
          $this->mensagem = $mensagem;
     }

}