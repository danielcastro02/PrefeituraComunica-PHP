<?php

if (realpath('./index.php')) {
    include_once './Controle/conexao.php';
    include_once './Modelo/Contato.php';
} else {
    if (realpath('../index.php')) {
        include_once '../Controle/conexao.php';
        include_once '../Modelo/Contato.php';
    } else {
        if (realpath('../../index.php')) {
            include_once '../../Controle/conexao.php';
            include_once '../../Modelo/Contato.php';
        }
    }
}


class ContatoPDO{
    
             /*inserir*/
    function inserirContato() {
        $contato = new contato($_POST);
            $con = new conexao();
            $pdo = $con->getConexao();
            $stmt = $pdo->prepare('insert into contato values(default , :id_usuario , :motivo , :mensagem);' );

            $stmt->bindValue(':id_usuario', $contato->getId_usuario());    
        
            $stmt->bindValue(':motivo', $contato->getMotivo());    
        
            $stmt->bindValue(':mensagem', $contato->getMensagem());    
        
            if($stmt->execute()){ 
                header('location: ../index.php?msg=contatoInserido');
            }else{
                header('location: ../index.php?msg=contatoErroInsert');
            }
    }
    /*inserir*/
                
    

            

    public function selectContato(){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from contato ;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectContatoId_contato($id_contato){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from contato where id_contato = :id_contato;');
        $stmt->bindValue(':id_contato', $id_contato);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectContatoId_usuario($id_usuario){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from contato where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectContatoMotivo($motivo){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from contato where motivo = :motivo;');
        $stmt->bindValue(':motivo', $motivo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    

                    
    public function selectContatoMensagem($mensagem){
            
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from contato where mensagem = :mensagem;');
        $stmt->bindValue(':mensagem', $mensagem);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }
    
 
    public function updateContato(Contato $contato){        
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update contato set id_usuario = :id_usuario , motivo = :motivo , mensagem = :mensagem where id_contato = :id_contato;');
        $stmt->bindValue(':id_usuario', $contato->getId_usuario());
        
        $stmt->bindValue(':motivo', $contato->getMotivo());
        
        $stmt->bindValue(':mensagem', $contato->getMensagem());
        
        $stmt->bindValue(':id_contato', $contato->getId_contato());
        $stmt->execute();
        return $stmt->rowCount();
    }            
    
    public function deleteContato($definir){
        $con = new conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('delete from contato where id_contato = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function deletar(){
        $this->deleteContato($_GET['id']);
        header('location: ../Tela/listarContato.php');
    }



            /*editar*/
            function editar() {
                $contato = new Contato($_POST);
                    if($this->updateContato($contato) > 0){
                        header('location: ../index.php?msg=contatoAlterado');
                    } else {
                        header('location: ../index.php?msg=contatoErroAlterar');
                    }
            }
            /*editar*/
            /*chave*/
            }
                