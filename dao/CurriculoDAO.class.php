<?php

if (file_exists('dao/GenericDAO.php')) {
    require_once 'dao/GenericDAO.php';
} else {
    require_once '../dao/GenericDAO.php';
}

class CurriculoDAO extends GenericDAO {

    public function salvar($oCurriculo, $oPessoa, $file) {
        $this->conexao->beginTransaction();
        try {

            require_once 'dao/PessoaDAO.class.php';

            $pessoaDAO = new PessoaDAO();
            $oPessoa = $pessoaDAO->AddPessoa($oPessoa, $this->conexao);

            if (!$oCurriculo->getId()) {
                $sql = "INSERT INTO curriculo(data_submissao,status,data_status,pessoa_id,area_cargo_id) values(:data_submissao,:status,:data_status,:pessoa_id,:area_cargo_id)";
            } else {
                $sql = "UPDATE curriculo SET data_submissao=:data_submissao,status=:status,data_status=:data_status,pessoa_id=:pessoa_id,area_cargo_id=:area_cargo_id WHERE id=:id";
            }

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':data_submissao', $oCurriculo->getData_submissao());
            $query->bindParam(':status', $oCurriculo->getStatus());
            $query->bindParam(':data_status', $oCurriculo->getData_status());
            $query->bindParam(':pessoa_id', $oPessoa->getId());
            $query->bindParam(':area_cargo_id', $oCurriculo->getArea_cargo_id());

            if ($oCurriculo->getId()) {
                $query->bindParam(':id', $oCurriculo->getId());
            }

            //Inicio Salvar curriculo

            $targetFolder = "curriculo/";

            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }

            //Aqui o teste
            $arrayBase = explode(".", basename($_FILES['file']['name']));
            $targetFolder .= $oPessoa->getId() . "." . $arrayBase[count($arrayBase) - 1];

            $ok = 1;

            $file_type = $_FILES['file']['type'];

            if ($file_type == "application/pdf" || $file_type == "application/msword" || $file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {

                if ($_FILES['file']['size'] > 3145728) {
                    //Tratamento sabe l? qual
                } else {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFolder)) {
                        //sucesso
                    } else {
                        //erro ao fazer upload
                    }
                }
            } else {
                echo "You may only upload a PDF, DOC or DOCX file<br>";
                echo "<a href='index.php'>Voltar</a>";
            }

            //Fim salvar curriculo

            $query->execute();

            if (!$oCurriculo->getId()) {
                $oCurriculo->setId($this->conexao->lastInsertId());
            }

            $this->conexao->commit();
        } catch (Exception $e) {
            $this->conexao->rollback();
            echo $e->getMessage();
        }
        return $oCurriculo;
    }

    public function salvarInscricao($oCurriculo) {
        $this->conexao->beginTransaction();
        try {

            require_once 'dao/PessoaDAO.class.php';

            $pessoaDAO = new PessoaDAO();
            $retorno = $pessoaDAO->salvarCompleto($oCurriculo->getOPessoa(), $this->conexao);

            if ($retorno[2] == 1)
                return $retorno;

            $sql = "INSERT INTO curriculo(data_submissao,status,data_status,pessoa_id,area_cargo_id) values(:data_submissao,:status,:data_status,:pessoa_id,:area_cargo_id)";

            $query = $this->conexao->prepare($sql);
            $query->bindParam(':data_submissao', $oCurriculo->getData_submissao());
            $query->bindParam(':status', $oCurriculo->getStatus());
            $query->bindParam(':data_status', $oCurriculo->getData_status());
            $query->bindParam(':pessoa_id', $oCurriculo->getOPessoa()->getId());
            $query->bindParam(':area_cargo_id', $oCurriculo->getArea_cargo_id());

            //Fim salvar curriculo

            $query->execute();

            if (!$oCurriculo->getId()) {
                $oCurriculo->setId($this->conexao->lastInsertId());
            }

            $this->conexao->commit();
        } catch (Exception $e) {
            $this->conexao->rollback();
            echo $e->getMessage();
        }
        return $retorno;
        // return $oCurriculo;
    }

    public function deletar($id) {

        $result = 1;

        $this->conexao->beginTransaction();
        try {
            $query = $this->conexao->prepare("SELECT id,pessoa_id FROM curriculo WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            $idPessoa = $query->fetch(PDO::FETCH_OBJ);
            $idPessoa = $idPessoa->pessoa_id;

            $query = $this->conexao->prepare("DELETE FROM curriculo WHERE id=:id");
            $query->bindParam(':id', $id);
            $query->execute();

            $this->conexao->commit();
            //if_exists docx,doc,pdf
            if (file_exists('curriculo/' . $idPessoa . '.pdf')) {
                unlink('curriculo/' . $idPessoa . '.pdf');
            } else if (file_exists('curriculo/' . $idPessoa . '.docx')) {
                unlink('curriculo/' . $idPessoa . '.docx');
            } else if (file_exists('curriculo/' . $idPessoa . '.doc')) {
                unlink('curriculo/' . $idPessoa . '.doc');
            }
        } catch (Exception $e) {
            $this->conexao->rollback();
            echo $e->getMessage();
            $result = 0;
        }
        return $result;
    }

    public function listar($pagina, $limite) {
        $vOCurriculos = Array();

        $query = $this->conexao->prepare('SELECT count(*) AS cont FROM curriculo');
        $query->execute();
        $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
        $numero_resultados = $numero_resultados->cont;

        $sql = "SELECT id, data_submissao,status,data_status,pessoa_id,area_cargo_id FROM curriculo";
        if ($limite > 0) {
            $sql .= " LIMIT " . ($pagina * $limite) . "," . $limite;
        }

        $query = $this->conexao->prepare($sql);
        $query->execute();

        $vOCurriculos = $query->fetchALL(PDO::FETCH_CLASS, 'Curriculo');

        if ($limite > 0) {

            $numero_paginas = ceil($numero_resultados / $limite);
            $_SESSION['numero_pag'] = $numero_paginas;
            if ($pagina > 0) {
                $pagina += $limite - 1;
            }
        }

        foreach ($vOCurriculos as $oCurriculo) {

            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado,permissao_id FROM pessoa WHERE id=:id");
            @$query->bindParam(':id', $oCurriculo->getPessoa_id());
            $query->execute();
            $vPessoa = $query->fetchALL(PDO::FETCH_CLASS, 'Pessoa');
            $oCurriculo->setOPessoa($vPessoa[0]);

            $query = $this->conexao->prepare("SELECT id,nome FROM area_cargo WHERE id=:id");
            @$query->bindParam(':id', $oCurriculo->getArea_cargo_id());
            $query->execute();
            $vAreaCargos = $query->fetchALL(PDO::FETCH_CLASS, 'AreaCargo');
            $oCurriculo->setOArea_cargo($vAreaCargos[0]);
        }

        return $vOCurriculos;
    }

    public function buscar($dataI, $dataF, $cargo, $status, $pagina, $limite) {

        $vOCurriculos = Array();

        $query = $this->conexao->prepare('SELECT count(*) AS cont FROM curriculo');
        $query->execute();
        $numero_resultados = $query->fetch(PDO::FETCH_OBJ);
        $numero_resultados = $numero_resultados->cont;

        $sql = "SELECT id, data_submissao,status,data_status,pessoa_id,area_cargo_id FROM curriculo";
        if ((($dataI != null && $dataF != null) || $cargo != null || $status != null)) {
            $sql .= " WHERE";
        }
        if ($dataI != null && $dataF != null) {
            $sql .= " data_submissao BETWEEN :dataI AND :dataF";
            if ($cargo != null || $status != null) {
                $sql .= " AND";
            }
        }
        if ($dataI != null && $dataF != null) {
            $sql .= " data_submissao BETWEEN :dataI AND :dataF";
            if ($cargo != null || $status != null) {
                $sql .= " AND";
            }
        }
        if ($cargo != null) {
            $sql .= " area_cargo_id = :cargo";
            if ($status != null) {
                $sql .= " AND";
            }
        }
        if ($status != null) {
            $sql .= " status = :status";
        }

        if ($limite > 0) {
            $sql .= " LIMIT " . ($pagina * $limite) . "," . $limite;
        }

        $query = $this->conexao->prepare($sql);
        if ($dataI != null && $dataF != null) {
            $query->bindParam(':dataI', $dataI);
            $query->bindParam(':dataF', $dataF);
        }
        if ($cargo != null) {
            $query->bindParam(':cargo', $cargo);
        }
        if ($status != null) {
            $query->bindParam(':status', $status);
        }
        $query->execute();
        $vOCurriculos = $query->fetchALL(PDO::FETCH_CLASS, 'Curriculo');

        if ($limite > 0) {

            $numero_paginas = ceil($numero_resultados / $limite);
            $_SESSION['numero_pag'] = $numero_paginas;
            if ($pagina > 0) {
                $pagina += $limite - 1;
            }
        }

        foreach ($vOCurriculos as $oCurriculo) {

            $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,bloqueado,permissao_id FROM pessoa WHERE id=:id");
            @$query->bindParam(':id', $oCurriculo->getPessoa_id());
            $query->execute();
            $vPessoa = $query->fetchALL(PDO::FETCH_CLASS, 'Pessoa');
            $oCurriculo->setOPessoa($vPessoa[0]);

            $query = $this->conexao->prepare("SELECT id,nome FROM area_cargo WHERE id=:id");
            @$query->bindParam(':id', $oCurriculo->getArea_cargo_id());
            $query->execute();
            $vAreaCargos = $query->fetchALL(PDO::FETCH_CLASS, 'AreaCargo');
            $oCurriculo->setOArea_cargo($vAreaCargos[0]);
        }

        return $vOCurriculos;
    }

    public function buscarImprimir($dataI, $dataF, $cargo, $status) {

        $vOCurriculos = Array(array(array()));

        $sql = "SELECT distinct c.id, c.data_submissao, c.status, c.data_status, "
                . "c.pessoa_id, c.area_cargo_id, p.nome, p.cpf, p.celular1, p.cidade, "
                . "a.nome as nomeCargo FROM curriculo c, area_cargo a, pessoa p"
                . " WHERE p.id=c.pessoa_id and a.id=c.area_cargo_id";

        if ($dataI != null && $dataF != null) {
            $sql .= " AND c.data_submissao BETWEEN :dataI AND :dataF";
        }

        if ($cargo != null) {
            $sql .= " AND c.area_cargo_id = :cargo";
        }
        if ($status != null) {
            $sql .= " AND c.status = :status";
        }

        //$sql .= " group by c.area_cargo_id";
        $sql .= " order by p.nome";

        //  echo $sql;
        //  exit;

        $query = $this->conexao->prepare($sql);
        if ($dataI != null && $dataF != null) {
            $query->bindParam(':dataI', $dataI);
            $query->bindParam(':dataF', $dataF);
        }
        if ($cargo != null) {
            $query->bindParam(':cargo', $cargo);
        }
        if ($status != null) {
            $query->bindParam(':status', $status);
        }
        $query->execute();
        $vCurriculos = $query->fetchALL(PDO::FETCH_ASSOC);

        foreach ($vCurriculos as $curriculo) {
            $oPessoa = new Pessoa();
            $oPessoa->setNome($curriculo['nome']);
            $oPessoa->setCpf($curriculo['cpf']);
            $oPessoa->setId($curriculo['pessoa_id']);
            $oPessoa->setCelular1($curriculo['celular1']);

            $oCargo = new AreaCargo();
            $oCargo->setId($curriculo['area_cargo_id']);
            $oCargo->setNome($curriculo['nomeCargo']);

            $oCurriculo = new Curriculo();
            $oCurriculo->setArea_cargo_id($curriculo['area_cargo_id']);
            $oCurriculo->setData_status($curriculo['data_status']);
            $oCurriculo->setData_submissao($curriculo['data_submissao']);
            $oCurriculo->setId($curriculo['id']);
            $oCurriculo->setOArea_cargo($oCargo);
            $oCurriculo->setOPessoa($oPessoa);
            $oCurriculo->setPessoa_id($curriculo['pessoa_id']);
            $oCurriculo->setStatus($curriculo['status']);

            //$vOCurriculos[$curriculo['area_cargo_id']][] = $oCurriculo;
            //$vOCurriculos[$curriculo['area_cargo_id']][$curriculo['cidade']][] = $oCurriculo;
         //   if ($curriculo['nomeCargo'] != NULL && $curriculo['nomeCargo'] != 0 
         //           && $curriculo['cidade']!=NULL && $curriculo['cidade']!=0) {
            $cidade = strtoupper($curriculo['cidade']);    
            //$vOCurriculos[$curriculo['nomeCargo']][$cidade][] = $oCurriculo;
            $vOCurriculos[$cidade][$curriculo['nomeCargo']][] = $oCurriculo;
         //   }
            //$vOCurriculos[$curriculo['cidade']][] = $oCurriculo;
        }

        //  echo count($vOCurriculos);
        //  exit;

        return $vOCurriculos;
    }

    public function buscarById($id) {

        $vOCurriculos = Array();
        $query = $this->conexao->prepare("SELECT id, data_submissao,status,data_status,pessoa_id,area_cargo_id FROM curriculo WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $vOCurriculos = $query->fetchALL(PDO::FETCH_CLASS, 'Curriculo');

        $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,"
                . "bloqueado,permissao_id, pai, mae, nascimento, logradouro, numero, bairro, cidade, "
                . "estado, nacionalidade, complemento, cep, estado_civil, celular3, rg, "
                . "data_emissao, orgao_emissor, reservista, conselho, conselho_numero, ctps, "
                . "serie, emissor_ctps FROM pessoa WHERE id=:id");
        @$query->bindParam(':id', $vOCurriculos[0]->getPessoa_id());
        $query->execute();
        $vPessoa = $query->fetchALL(PDO::FETCH_CLASS, 'Pessoa');
        $vOCurriculos[0]->setOPessoa($vPessoa[0]);

        $query = $this->conexao->prepare("SELECT id,nome FROM area_cargo WHERE id=:id");
        @$query->bindParam(':id', $vOCurriculos[0]->getArea_cargo_id());
        $query->execute();
        $vAreaCargos = $query->fetchALL(PDO::FETCH_CLASS, 'AreaCargo');
        $vOCurriculos[0]->setOArea_cargo($vAreaCargos[0]);

        return $vOCurriculos[0];
    }

    public function buscarByCpf($cpf) {

        $cpf2 = str_replace('-', '', str_replace('.', '', $cpf));

        $vOCurriculos = Array();
        $query = $this->conexao->prepare("SELECT id,nome,cpf,telefone,celular1,celular2,email,"
                . "bloqueado,permissao_id, pai, mae, nascimento, logradouro, numero, bairro, cidade, "
                . "estado, nacionalidade, complemento, cep, estado_civil, celular3, rg, "
                . "data_emissao, orgao_emissor, reservista, conselho, conselho_numero, ctps, "
                . "serie, emissor_ctps FROM pessoa WHERE cpf=:cpf or cpf=:cpf2");
        @$query->bindParam(':cpf', $cpf);
        @$query->bindParam(':cpf2', $cpf2);
        $query->execute();
        $vPessoa = $query->fetchALL(PDO::FETCH_CLASS, 'Pessoa');

        if (count($vPessoa) > 0) {


            $query = $this->conexao->prepare("SELECT id, data_submissao,status,data_status,pessoa_id,area_cargo_id FROM curriculo WHERE pessoa_id=:pessoa_id");
            $query->bindParam(":pessoa_id", $vPessoa[0]->getId());
            $query->execute();
            $vOCurriculos = $query->fetchALL(PDO::FETCH_CLASS, 'Curriculo');
            $vOCurriculos[0]->setOPessoa($vPessoa[0]);

            $query = $this->conexao->prepare("SELECT id,nome FROM area_cargo WHERE id=:id");
            @$query->bindParam(':id', $vOCurriculos[0]->getArea_cargo_id());
            $query->execute();
            $vAreaCargos = $query->fetchALL(PDO::FETCH_CLASS, 'AreaCargo');
            $vOCurriculos[0]->setOArea_cargo($vAreaCargos[0]);

            return $vOCurriculos[0];
        } else {
            return false;
        }
    }

    public function mudarStatus($id, $status) {
        $this->conexao->BeginTransaction();
        try {
            date_default_timezone_set('Brazil/East');
            $dataStatus = date('Y-m-d H-i-s', time());
            $query = $this->conexao->prepare('UPDATE curriculo SET status=:status,data_status=:data_status WHERE id=:id');
            $query->bindParam(":status", $status);
            $query->bindParam(":data_status", $dataStatus);
            $query->bindParam(":id", $id);
            $query->execute();
            $this->conexao->commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->conexao->rollBack();
        }
    }

}
