<?php

if (file_exists('dao/GenericDAO.php')) {
    require_once 'dao/GenericDAO.php';
} else {
    require_once '../dao/GenericDAO.php';
}

class PessoaDAO extends GenericDAO {

    public function salvar($oPessoa) {

        $this->conexao->beginTransaction();

        $query = $this->conexao->prepare('SELECT cpf FROM pessoa WHERE cpf=:cpf');
        $query->bindParam(':cpf', $oPessoa->getCpf());
        $query->execute();
        $cpfU = $query->fetchAll(PDO::FETCH_OBJ);

        try {

            if ($cpfU[0]->cpf != null) {
                $sql = "UPDATE pessoa SET nome=:nome,cpf=:cpf,email=:email,celular1=:celular1,celular2=:celular2,telefone=:telefone,bloqueado=:bloqueado,permissao_id=:permissao_id,senha=:senha WHERE cpf=:cpf";
            } else if (!$oPessoa->getId()) {

                $sql = "INSERT INTO pessoa(nome,cpf,email,celular1,celular2,telefone,senha,bloqueado,permissao_id) values(:nome,:cpf,:email,:celular1,:celular2,:telefone,:senha,:bloqueado,:permissao_id)";
            } else {
                $sql = "UPDATE pessoa SET nome=:nome,cpf=:cpf,email=:email,celular1=:celular1,celular2=:celular2,telefone=:telefone,bloqueado=:bloqueado,permissao_id=:permissao_id WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':nome', $oPessoa->getNome());
            $query->bindParam(':cpf', $oPessoa->getCpf());
            $query->bindParam(':email', $oPessoa->getEmail());
            $query->bindParam(':celular1', $oPessoa->getCelular1());
            $query->bindParam(':celular2', $oPessoa->getCelular2());
            $query->bindParam(':telefone', $oPessoa->getTelefone());

            if ($oPessoa->getSenha() != null) {
                //Outro md5...ou não?
                $query->bindParam(':senha', md5($oPessoa->getSenha()));
            }

            $query->bindParam(':bloqueado', $oPessoa->getBloqueado());
            $query->bindParam(':permissao_id', $oPessoa->getPermissao_id());

            if ($oPessoa->getId()) {
                $query->bindParam(':id', $oPessoa->getId());
            }

            $query->execute();

            if (!$oPessoa->getId()) {
                $oPessoa->setId($this->conexao->lastInsertId());
            }

            $this->conexao->commit();
        } catch (Exception $e) {
            $this->conexao->rollback();
            echo $e->getMessage();
        }
        return $oPessoa;
    }

    public function AddPessoa($oPessoa, $conexao = null) {

        if ($conexao == null) {
            return 0;
        }

        $query = $this->conexao->prepare('SELECT id,cpf FROM pessoa WHERE cpf=:cpf');
        $query->bindParam(':cpf', $oPessoa->getCpf());
        $query->execute();
        $cpfU = $query->fetchAll(PDO::FETCH_OBJ);

        try {

            if (isset($cpfU[0]) && $cpfU[0]->cpf != null) {
                $sql = "UPDATE pessoa SET nome=:nome,cpf=:cpf,email=:email,celular1=:celular1,celular2=:celular2,telefone=:telefone,bloqueado=:bloqueado,permissao_id=:permissao_id,senha=:senha WHERE cpf=:cpf";
            } else {

                $sql = "INSERT INTO pessoa(nome,cpf,email,celular1,celular2,telefone,senha,bloqueado,permissao_id) values(:nome,:cpf,:email,:celular1,:celular2,:telefone,:senha,:bloqueado,:permissao_id)";
            }
            if ($oPessoa->getId()) {
                $sql = "UPDATE pessoa SET nome=:nome,cpf=:cpf,email=:email,celular1=:celular1,celular2=:celular2,telefone=:telefone,bloqueado=:bloqueado,senha=:senha,permissao_id=:permissao_id WHERE id=:id";
            }

            $query = $conexao->prepare($sql);
            $query->bindParam(':nome', $oPessoa->getNome());
            $query->bindParam(':cpf', $oPessoa->getCpf());
            $query->bindParam(':email', $oPessoa->getEmail());
            $query->bindParam(':celular1', $oPessoa->getCelular1());
            $query->bindParam(':celular2', $oPessoa->getCelular2());
            $query->bindParam(':telefone', $oPessoa->getTelefone());
            $query->bindParam(':bloqueado', $oPessoa->getBloqueado());
            $query->bindParam(':permissao_id', $oPessoa->getPermissao_id());
            if ($oPessoa->getSenha() != null) {
                $senha = md5($oPessoa->getSenha());
            } else {
                $senha = null;
            }
            $query->bindParam(':senha', $senha);

            if ($oPessoa->getId() != null) {
                $query->bindParam(':id', $oPessoa->getId());
            }

            $query->execute();
            if (isset($cpfU[0]) && $cpfU[0]->cpf != null) {
                $oPessoa->setId($cpfU[0]->id);
            } else if (!$oPessoa->getId()) {
                $oPessoa->setId($conexao->lastInsertId());
            }
        } catch (Exception $e) {
            $conexao->rollback();
            echo $e->getMessage();
        }

        return $oPessoa;
    }

    public function salvarCompleto($oPessoa, $conexao = null) {

        if ($conexao == null) {
            return 0;
        }
        $this->conexao = $conexao;

        $cpf2 = str_replace('-', '', str_replace('.', '', $oPessoa->getCpf()));

        $query = $this->conexao->prepare('SELECT id,cpf FROM pessoa WHERE cpf=:cpf or cpf=:cpf2');
        $query->bindParam(':cpf', $oPessoa->getCpf());
        $query->bindParam(':cpf2', $cpf2);
        $query->execute();
        $cpfU = $query->fetchAll(PDO::FETCH_OBJ);

        try {

            if (isset($cpfU[0]) && $cpfU[0]->cpf != null) {
                $retorno = array();
                $retorno[0] = "CPF já inscrico. Não foi possível realizar nova inscrição.";
                $retorno[1] = $cpfU[0];
                $retorno[2] = 1;
                return $retorno;
                //$sql = "UPDATE pessoa SET nome=:nome,cpf=:cpf,email=:email,celular1=:celular1,celular2=:celular2,telefone=:telefone,bloqueado=:bloqueado,permissao_id=:permissao_id,senha=:senha WHERE cpf=:cpf";
            } else {
                $retorno[0] = "   CPF já inscrito. Não foi possível realizar nova inscrição.";
                $retorno[1] = $cpfU[0];
                $retorno[2] = 2;

                $sql = "INSERT INTO pessoa(nome,cpf,email,celular1,celular2,telefone,senha,bloqueado, "
                        . "permissao_id, pai, mae, nascimento, logradouro, numero, bairro, cidade, "
                        . "estado, nacionalidade, complemento, cep, estado_civil, celular3, rg, "
                        . "data_emissao, orgao_emissor, reservista, conselho, conselho_numero, ctps, "
                        . "serie, emissor_ctps) values(:nome,:cpf,:email,:celular1,"
                        . ":celular2,:telefone,:senha,:bloqueado,:permissao_id,"
                        . ":pai, :mae, :nascimento, :logradouro, :numero, :bairro, :cidade, "
                        . ":estado, :nacionalidade, :complemento, :cep, :estado_civil, :celular3, :rg, "
                        . ":data_emissao, :orgao_emissor, :reservista, :conselho, :conselho_numero, :ctps, "
                        . ":serie, :emissor_ctps)";
            }

            if ($oPessoa->getId()) {
                $sql = "UPDATE pessoa SET nome=:nome,cpf=:cpf,email=:email,celular1=:celular1,celular2=:celular2,telefone=:telefone,bloqueado=:bloqueado,senha=:senha,permissao_id=:permissao_id WHERE id=:id";
            }

            $query = $conexao->prepare($sql);
            $query->bindParam(':nome', $oPessoa->getNome());
            $query->bindParam(':cpf', $oPessoa->getCpf());
            $query->bindParam(':email', $oPessoa->getEmail());
            $query->bindParam(':celular1', $oPessoa->getCelular1());
            $query->bindParam(':celular2', $oPessoa->getCelular2());
            $query->bindParam(':telefone', $oPessoa->getTelefone());
            $query->bindParam(':bloqueado', $oPessoa->getBloqueado());
            $query->bindParam(':permissao_id', $oPessoa->getPermissao_id());

            if (!(isset($cpfU[0]) && $cpfU[0]->cpf != null)) {
                $query->bindParam(':pai', $oPessoa->getPai());
                $query->bindParam(':mae', $oPessoa->getMae());
                $query->bindParam(':nascimento', $oPessoa->getNascimento());
                $query->bindParam(':logradouro', $oPessoa->getLogradouro());
                $query->bindParam(':numero', $oPessoa->getNumero());
                $query->bindParam(':bairro', $oPessoa->getBairro());
                $query->bindParam(':cidade', $oPessoa->getCidade());
                $query->bindParam(':estado', $oPessoa->getEstado());
                $query->bindParam(':nacionalidade', $oPessoa->getNacionalidade());
                $query->bindParam(':complemento', $oPessoa->getComplemento());
                $query->bindParam(':cep', $oPessoa->getCep());
                $query->bindParam(':estado_civil', $oPessoa->getEstado_civil());
                $query->bindParam(':celular3', $oPessoa->getCelular3());
                $query->bindParam(':rg', $oPessoa->getRg());
                $query->bindParam(':data_emissao', $oPessoa->getData_emissao());
                $query->bindParam(':orgao_emissor', $oPessoa->getOrgao_emissor());
                $query->bindParam(':reservista', $oPessoa->getReservista());
                $query->bindParam(':conselho', $oPessoa->getConselho());
                $query->bindParam(':conselho_numero', $oPessoa->getConselho_numero());
                $query->bindParam(':ctps', $oPessoa->getCtps());
                $query->bindParam(':serie', $oPessoa->getSerie());
                $query->bindParam(':emissor_ctps', $oPessoa->getEmissor_ctps());
            }

            if ($oPessoa->getSenha() != null) {
                $senha = md5($oPessoa->getSenha());
            } else {
                $senha = null;
            }
            $query->bindParam(':senha', $senha);

            if ($oPessoa->getId() != null) {
                $query->bindParam(':id', $oPessoa->getId());
            }

            $query->execute();
            if (isset($cpfU[0]) && $cpfU[0]->cpf != null) {
                $oPessoa->setId($cpfU[0]->id);
            } else if (!$oPessoa->getId()) {
                $oPessoa->setId($conexao->lastInsertId());
            }
        } catch (Exception $e) {
            
        }
        return $retorno;
        //  return $oPessoa;
    }

    public function deletar($id) {

        $result = 1;

        $this->conexao->beginTransaction();
        try {
            $query = $this->conexao->prepare("DELETE FROM pessoa WHERE id=:id");
            $query->bindParam(':id', $id);
            $query->execute();

            $this->conexao->commit();
        } catch (Exception $e) {
            $this->conexao->rollback();
            echo $e->getMessage();
            $result = 0;
        }
        return $result;
    }

    public function listar($pagina = null, $limite = null) {
        $vOPessoas = Array();

        $query = $this->conexao->prepare('SELECT count(*) AS cont FROM pessoa');
        $query->execute();
        $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
        $numero_resultados = $numero_resultados->cont;

        $sql = "SELECT id, nome,cpf, bloqueado,permissao_id FROM pessoa";
        if ($limite > 0) {
            $sql .= " LIMIT " . ($pagina * $limite) . "," . $limite;
        }

        $query = $this->conexao->prepare($sql);
        $query->execute();
        $vOPessoas = $query->fetchALL(PDO::FETCH_CLASS, 'Pessoa');

        if ($limite > 0) {

            $numero_paginas = ceil($numero_resultados / $limite);
            $_SESSION['numero_pag'] = $numero_paginas;
            if ($pagina > 0) {
                $pagina += $limite - 1;
            }
        }

        foreach ($vOPessoas as $oPessoa) {
            $query = $this->conexao->prepare("SELECT id,nome FROM permissao WHERE id=:id");
            @$query->bindParam(':id', $oPessoa->getPermissao_id());
            $query->execute();
            $vPermissao = $query->fetchALL(PDO::FETCH_CLASS, 'Permissao');

            $oPessoa->setOPermissao($vPermissao[0]);
        }

        return $vOPessoas;
    }

    public function buscar($nome, $pagina, $limite) {
        if (file_exists('../modelo/Permissao.class.php')) {
            require_once '../modelo/Permissao.class.php';
        }

        $nome = "%" . $nome . "%";

        $query = $this->conexao->prepare('SELECT count(*) AS cont FROM pessoa');
        $query->execute();
        $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
        $numero_resultados = $numero_resultados->cont;

        $sql = "SELECT id,nome,cpf,email, bloqueado,permissao_id,telefone FROM pessoa WHERE nome like :nome OR cpf LIKE :cpf";
        if ($limite > 0) {
            $sql .= " LIMIT " . ($pagina * $limite) . "," . $limite;
        }

        $query = $this->conexao->prepare($sql);
        $query->bindParam(':nome', $nome);
        $query->bindParam(':cpf', $nome);
        $query->execute();
        $oPessoas = $query->fetchALL(PDO::FETCH_CLASS, 'Pessoa');

        if ($limite > 0) {

            $numero_paginas = ceil($numero_resultados / $limite);
            $_SESSION['numero_pag'] = $numero_paginas;
            if ($pagina > 0) {
                $pagina += $limite - 1;
            }
        }

        if (count($oPessoas) >= 1) {
            foreach ($oPessoas as $oPessoa) {
                $query = $this->conexao->prepare("SELECT id,nome FROM permissao WHERE id=:id");
                @$query->bindParam(':id', $oPessoa->getPermissao_id());
                $query->execute();
                $vPermissao = $query->fetchALL(PDO::FETCH_CLASS, 'Permissao');

                $oPessoa->setOPermissao($vPermissao[0]);
            }
        }

        return $oPessoas;
    }

    public function buscarById($id) {

        $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado,permissao_id FROM pessoa WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $vPessoa = $query->fetchALL(PDO::FETCH_CLASS, 'Pessoa');

        if ($vPessoa == null) {
            return null;
        }

        $query = $this->conexao->prepare("SELECT id,nome FROM permissao WHERE id=:id");
        @$query->bindParam(':id', $vPessoa[0]->getPermissao_id());
        $query->execute();
        $vPermissao = $query->fetchALL(PDO::FETCH_CLASS, 'Permissao');

        $vPessoa[0]->setOPermissao($vPermissao[0]);

        return $vPessoa[0];
    }

    //métodos para senha

    public function resgatarSenha($id) {

        $query = $this->conexao->prepare("SELECT id,nome,cpf,senha FROM pessoa WHERE id=:id");
        $query->bindparam(':id', $id);
        $query->exetcute();

        $oPessoa = $query->fetchAll(PDO::FETCH_CLASS, 'Pessoa');

        return $oPessoa[0];
    }

    //Métodos referentes a login
    public function identifica($usuario, $senha) {

        $senha = md5($senha);
        $sql = "SELECT id,nome, cpf,senha,bloqueado,permissao_id  FROM pessoa WHERE cpf=:usuario AND senha=:senha AND bloqueado=:bloqueado";

        $oAP = NULL;
        $query = $this->conexao->prepare($sql);
        $query->bindParam(':usuario', $usuario);
        $bloqueado = "N";
        $query->bindParam(':bloqueado', $bloqueado);

        $query->bindParam(':senha', $senha);

        $query->execute();
        $resultado = $query->fetchAll(PDO::FETCH_CLASS, 'Pessoa');

        if (count($resultado) != 0) {
            $oAP = $resultado[0];
            $query = $this->conexao->prepare('SELECT id,nome FROM permissao WHERE id=:id');
            @$query->bindParam(':id', $oAP->getPermissao_id());
            $query->execute();
            $oPermissao = $query->fetchAll(PDO::FETCH_CLASS, 'Permissao');
            $oAP->setOPermissao($oPermissao[0]);
        }

        return $oAP;
    }

    public function bloquear($id, $status) {

        $result = 1;
        $this->conexao->beginTransaction();
        try {
            $query = $this->conexao->prepare("UPDATE pessoa SET bloqueado=:bloqueado WHERE id=:id");
            $query->bindParam(':id', $id);
            $query->bindParam(':bloqueado', $status);
            $query->execute();

            $this->conexao->commit();
        } catch (Exception $e) {
            $this->conexao->rollback();
            echo $e->getMessage();
            $result = 0;
        }
        return $result;
    }

    public function alterarSenha($oPessoa) {
        $senha = md5($oPessoa->getSenha());
        $this->conexao->beginTransaction();
        try {
            $query = $this->conexao->prepare("UPDATE pessoa SET senha=:senha WHERE id=:id");
            @$query->bindParam(':id', $oPessoa->getId());
            $query->bindParam(':senha', $senha);
            $query->execute();

            $this->conexao->commit();
        } catch (Exception $e) {
            $this->conexao->rollback();
            echo $e->getMessage();
        }
        return $senha;
    }

}

?>