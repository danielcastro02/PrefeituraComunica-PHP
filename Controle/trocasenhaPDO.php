<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Trocasenha.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Trocasenha.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Trocasenha.php';
        }
    }
}


class TrocasenhaPDO{
    /*inserir*/
    function inserirTrocasenha(trocasenha $trocasenha) {
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('insert into trocasenha values(default , :id_usuario , default);' );
        $stmt->bindValue(':id_usuario', $trocasenha->getId_usuario());    
        if($stmt->execute()){ 
            return true;
        }else{
            return false;
        }
    }
    /*inserir*/
    

            

    public function selectTrocasenha(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from trocasenha ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectTrocasenhaId_troSenha($id_troSenha){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from trocasenha where id_troSenha = :id_troSenha;');
        $stmt->bindValue(':id_troSenha', $id_troSenha);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectTrocasenhaId_usuario($id_usuario){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from trocasenha where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectTrocasenhaHora($hora){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from trocasenha where hora = :hora;');
        $stmt->bindValue(':hora', $hora);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateTrocasenha(Trocasenha $trocasenha){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update trocasenha set id_usuario = :id_usuario , hora = :hora where id_troSenha = :id_troSenha;');
        $stmt->bindValue(':id_usuario', $trocasenha->getId_usuario());
        
        $stmt->bindValue(':hora', $trocasenha->getHora());
        
        $stmt->bindValue(':id_troSenha', $trocasenha->getId_troSenha());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteTrocasenha($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from trocasenha where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function deletar(){
        $this->deleteTrocasenha($_GET['id']);
        header('location: ../Tela/listarTrocasenha.php');
    }


/*chave*/}
