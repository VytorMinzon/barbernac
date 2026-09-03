<?php

class BarbeirosController extends Controller
{


    public function index()
    {

        $dados = array();

        $dados['mensagem'] = 'Bem-vindo a BarberNac';

        $funcionarioModel = new Funcionario();
        $dados['funcionarios'] = $funcionarioModel->getListarFuncionarios();

        $this->carregarViews('barbeiros', $dados);
    }
}
