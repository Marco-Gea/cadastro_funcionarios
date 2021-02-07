<?php 

namespace App\Models;

//Use abstract class for models
use MF\Model\Model;

//Funcionarios's class
class Funcionarios extends Model{
    private $id, $nome, $fone, $email, $cpf, $rg, $cep, $uf, $cidade, $logradouro, $endereco, $numero, $funcao, $salario, $obs;
    private $foto, $fotoAnt, $tmp_img;
    private $search;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    // Insere um funcionário no banco de dados 
    public function create(){
        $query = "insert into tb_funcionarios(nome, fone, email, cpf, rg, cep, uf, cidade, logradouro, endereco, numero, funcao, salario, foto, obs)
        values(:nome, :fone, :email, :cpf, :rg, :cep, :uf, :cidade, :logradouro, :endereco, :numero, :funcao, :salario, :foto, :obs)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':fone', $this->__get('fone'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':rg', $this->__get('rg'));
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':logradouro', $this->__get('logradouro'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->bindValue(':funcao', $this->__get('funcao'));
        $stmt->bindValue(':salario', $this->__get('salario'));
        $stmt->bindValue(':foto', $this->__get('foto'));
        $stmt->bindValue(':obs', $this->__get('obs'));

        $stmt->execute();

        $this->uploadImg();

        $funcionario = $this->getFuncByCpf();

        $this->__set('id', $funcionario['id']);

        return $this;
    }

    // Recupera lista de funcionarios a partir do cpf
    public function getFuncByCpf(){
        $query = "select * from tb_funcionarios where cpf like :cpf";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cpf', "%" . $this->__get('cpf') . "%");
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Recupera lista de funcionarios a partir do nome ou email
    public function getFuncByNameOrEmail(){
        $query = "select * from tb_funcionarios where nome like :nome or email like :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', "%" . $this->__get('nome') . "%");
        $stmt->bindValue(':email', "%" . $this->__get('email') . "%");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Recupera funcionário pelo ID
    public function getFuncById(){
        $query = "select * from tb_funcionarios where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    } 

    // Recupera todos os dados
    public function getAll(){
        $query = "select * from tb_funcionarios";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Excluir dados do banco
    public function delete(){
        $query = "delete from tb_funcionarios where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        $this->deleteImg();
        return $this;
    }

    // Alterar os dados do banco
    public function update(){
        $query = "update tb_funcionarios
                    set nome = :nome, fone = :fone, email = :email, cpf = :cpf, 
                    rg = :rg, cep = :cep, uf = :uf, cidade = :cidade, logradouro = :logradouro, 
                    endereco = :endereco, numero = :numero, funcao = :funcao, salario = :salario, foto = :foto, obs = :obs
                    where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue('id', $this->__get('id'));
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':fone', $this->__get('fone'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':rg', $this->__get('rg'));
        $stmt->bindValue(':cep', $this->__get('cep'));
        $stmt->bindValue(':uf', $this->__get('uf'));
        $stmt->bindValue(':cidade', $this->__get('cidade'));
        $stmt->bindValue(':logradouro', $this->__get('logradouro'));
        $stmt->bindValue(':endereco', $this->__get('endereco'));
        $stmt->bindValue(':numero', $this->__get('numero'));
        $stmt->bindValue(':funcao', $this->__get('funcao'));
        $stmt->bindValue(':salario', $this->__get('salario'));
        $stmt->bindValue(':obs', $this->__get('obs'));

        // Caso o usuário selecione uma nova foto, ela será enviada para o servidor
        if($this->__get('foto') != '' && $this->__get('foto') != $this->__get('fotoAnt')){
            $stmt->bindValue(':foto', $this->__get('foto'));
            $this->deleteImg();
            $this->uploadImg();
        }else{
            $stmt->bindValue(':foto', $this->__get('fotoAnt'));
        }

        $stmt->execute();

        return $this;
    }

    // Envia a foto para o servidor 
    private function uploadImg(){
        $this->__set('diretorio', 'imagens/' . $this->db->lastInsertId() . '/');
        mkdir($this->__get('diretorio'), 0755);
        move_uploaded_file($this->__get('tmp_img'), $this->__get('diretorio') . $this->__get('foto'));
    }

    // Remove a foto do funcionário que está sendo excluído
    private function deleteImg(){
        $this->__set('diretorio', 'imagens/' . $this->__get('id') . '/');
        $func = $this->getFuncById();
        unlink($this->__get('diretorio') . $func['foto']);
        rmdir($this->__get('diretorio'));
    }
}

?>