<?php

/**
 * Description
 *
 * @author Igor de Lima Mendes
 */
class Pessoa {

    private $id;
    private $nome;
    private $cpf;
    private $telefone;
    private $celular1;
    private $celular2;
    private $email;
    private $senha;
    private $bloqueado;
    private $permissao_id;
    
    private $pai;
    private $mae;
    private $nascimento;
    private $logradouro;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $nacionalidade;
    private $complemento;
    private $cep;
    private $estado_civil;
    private $celular3;
    private $rg;
    private $data_emissao;
    private $orgao_emissor;
    private $reservista;
    private $conselho;
    private $conselho_numero;
    private $ctps;
    private $serie;
    private $emissor_ctps;
    
    private $oPermissao;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getCelular1() {
        return $this->celular1;
    }

    public function getCelular2() {
        return $this->celular2;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getBloqueado() {
        return $this->bloqueado;
    }

    public function getPermissao_id() {
        return $this->permissao_id;
    }

    public function getOPermissao() {
        return $this->oPermissao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setCelular1($celular1) {
        $this->celular1 = $celular1;
    }

    public function setCelular2($celular2) {
        $this->celular2 = $celular2;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $senha = md5("hgvj" . $senha . "linkdesign");
        $this->senha = $senha;
    }

    public function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }

    public function setPermissao_id($permissao_id) {
        $this->permissao_id = $permissao_id;
    }

    public function setOPermissao($oPermissao) {
        $this->oPermissao = $oPermissao;
    }
    
    public function getPai() {
        return $this->pai;
    }

    public function getMae() {
        return $this->mae;
    }

    public function getNascimento() {
        return $this->nascimento;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getNacionalidade() {
        return $this->nacionalidade;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getEstado_civil() {
        return $this->estado_civil;
    }

    public function getCelular3() {
        return $this->celular3;
    }

    public function getRg() {
        return $this->rg;
    }

    public function getData_emissao() {
        return $this->data_emissao;
    }

    public function getOrgao_emissor() {
        return $this->orgao_emissor;
    }

    public function getReservista() {
        return $this->reservista;
    }

    public function getConselho() {
        return $this->conselho;
    }

    public function getConselho_numero() {
        return $this->conselho_numero;
    }

    public function getCtps() {
        return $this->ctps;
    }

    public function getSerie() {
        return $this->serie;
    }

    public function getEmissor_ctps() {
        return $this->emissor_ctps;
    }

    public function setPai($pai) {
        $this->pai = $pai;
    }

    public function setMae($mae) {
        $this->mae = $mae;
    }

    public function setNascimento($nascimento) {
        $this->nascimento = $nascimento;
    }

    public function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setEstado_civil($estado_civil) {
        $this->estado_civil = $estado_civil;
    }

    public function setCelular3($celular3) {
        $this->celular3 = $celular3;
    }

    public function setRg($rg) {
        $this->rg = $rg;
    }

    public function setData_emissao($data_emissao) {
        $this->data_emissao = $data_emissao;
    }

    public function setOrgao_emissor($orgao_emissor) {
        $this->orgao_emissor = $orgao_emissor;
    }

    public function setReservista($reservista) {
        $this->reservista = $reservista;
    }

    public function setConselho($conselho) {
        $this->conselho = $conselho;
    }

    public function setConselho_numero($conselho_numero) {
        $this->conselho_numero = $conselho_numero;
    }

    public function setCtps($ctps) {
        $this->ctps = $ctps;
    }

    public function setSerie($serie) {
        $this->serie = $serie;
    }

    public function setEmissor_ctps($emissor_ctps) {
        $this->emissor_ctps = $emissor_ctps;
    }

}

?>