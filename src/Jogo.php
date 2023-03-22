<?php

namespace App;

use App\Prato;

class Jogo
{
    private $tipoPratos = array();

    public function __construct()
    {
        /**
         * @var Array<string, Array<Prato>>
         */
        $this->tipoPratos = [
            'Massa' => [new Prato("Lasanha")],
            "Bolo de Chocolate" => []
        ];
    }

    public function inicializa()
    {
        echo '-------------------------------------------' . PHP_EOL;
        echo 'Pense um prato que gosta' . PHP_EOL;
        echo 'Pressione qualquer tecla para começar' . PHP_EOL;
        echo '-------------------------------------------' . PHP_EOL;
        readline();

        $this->start();
    }

    private function start()
    {
        foreach ($this->tipoPratos as $tipoPrato => $prato) {
            $resposta = $this->pergunta($tipoPrato);

            if ($resposta && count($prato) > 0) {
                $this->pratos($prato, $tipoPrato);
                break;
            }

            $this->verificaSeAcertei($resposta);


            $this->ultimaPosicaoCriaNovoPrato($this->tipoPratos, $tipoPrato);
        }
    }

    private function verificaSeAcertei($resposta)
    {
        if ($resposta) {
            $this->acertei();
        }
    }

    private function ultimaPosicaoCriaNovoPrato(array $array, string $key, string $tipo = "")
    {
        if ($key == array_key_last($array)) {
            $this->novoPrato($tipo);
        }
    }


    private function novoPrato($tipo)
    {
        $prato = readline("Qual prato você pensou ?" . PHP_EOL);

        if ($tipo == "") {
            $tipo = $this->novoTipo($prato);
        }

        $this->adicionaNovoPratoTipo($tipo, $prato);
        $this->inicializa();
    }

    private function adicionaNovoPratoTipo(string $tipo, string $novoPrato)
    {
        $this->tipoPratos[$tipo][] = new Prato($novoPrato);
    }

    private function novoTipo(string $novoPrato)
    {
        return readline($novoPrato . " é _________ mas bolo de chocolate não ?" . PHP_EOL);
    }

    private function pratos(array $pratos, string $tipo)
    {

        foreach ($pratos as $key => $prato) {
            $resposta = $this->pergunta($prato->getNome());
            $this->verificaSeAcertei($resposta);

            $this->ultimaPosicaoCriaNovoPrato($pratos, $key, $tipo);
        }
    }

    private function pergunta(string $texto)
    {
        echo "O prato que você pensou é " . $texto . PHP_EOL;
        while (true) {
            $resposta = readline("Digite S para sim e N para não:" . PHP_EOL);
            switch ($resposta) {
                case 'S':
                case 's':
                    return true;
                    break;
                case 'N':
                case 'n':
                    return false;
                    break;
            }
        }
    }

    private function acertei()
    {
        echo "Acertei de novo!" . PHP_EOL;
        $this->inicializa();
    }
}
