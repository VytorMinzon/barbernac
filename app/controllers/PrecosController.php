<?php

class PrecosController extends Controller
{
    public function index()
    {
        $servicoModel = new Servico();
        $servicos = $servicoModel->getListarServicos(); // Puxa os serviços ativos ordenados por nome

        $dados = array();
        $dados['titulo'] = 'Preços - BarberNac';
        $dados['servicos'] = $servicos; // envia os serviços para a view

        $this->carregarViews('precos', $dados);
    }
}
