<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escuta Minha Voz</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h2 {
            font-size: 44px;
            margin-top: 60px;
            margin-bottom: 25px;
        }

        .categoria {
            margin-bottom: 70px;
        }

        button {
            font-size: 36px;
            padding: 32px;
            margin: 18px auto;
            width: 85%;
            max-width: 650px;
            display: block;
            border-radius: 22px;
            border: none;
            color: #ffffff;
            transition: border 0.2s ease, transform 0.1s ease;
            position: relative;
        }

        button:active {
            transform: scale(0.97);
        }

        button.tocando {
            border: 5px solid #000000;
            /* contorno preto */
        }

        /* Cores por categoria (alto contraste) */
        .basicas button {
            background-color: #2d89ef;
        }

        .saude button {
            background-color: #d13438;
        }

        .emocoes button {
            background-color: #107c10;
        }

        /* Botão de emergência quadradinho */
        #botaoEmergencia {
            position: fixed;
            position: fixed;
            top: 20px;
            right: 20px;
            width: 100px;
            height: 100px;
            font-size: 20px;
            padding: 0;
            background-color: #ff0000;
            border-radius: 15px;
            color: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        }
    </style>
</head>

<body>

    <!-- Botão de emergência pequeno quadrado -->
    <button id="botaoEmergencia" onclick="tocarAudio('audio_0<?php echo md5('Saúde'); ?>')">SOS</button>

    <?php
    $categorias = [

        "Necessidades Básicas" => [
            ["texto" => "FOME", "audio" => "fome.mp3"],
            ["texto" => "SEDE", "audio" => "sede.mp3"],
            ["texto" => "BANHEIRO", "audio" => "banheiro.mp3"],
            ["texto" => "CANSADO", "audio" => "cansado.mp3"]
        ],

        "Saúde" => [
            ["texto" => "NÃO ESTOU BEM", "audio" => "nao_estou_bem.mp3"],
            ["texto" => "DOR", "audio" => "dor.mp3"]
        ],

        "Emoções" => [
            ["texto" => "FELIZ", "audio" => "feliz.mp3"],
            ["texto" => "TRISTE", "audio" => "triste.mp3"],
            ["texto" => "EU TE AMO", "audio" => "eu_te_amo.mp3"]
        ]
    ];

    foreach ($categorias as $nomeCategoria => $frases) {

        $classeCategoria = "";

        if ($nomeCategoria === "Necessidades Básicas") {
            $classeCategoria = "basicas";
        } elseif ($nomeCategoria === "Saúde") {
            $classeCategoria = "saude";
        } elseif ($nomeCategoria === "Emoções") {
            $classeCategoria = "emocoes";
        }

        echo "<div class='categoria $classeCategoria'>";
        echo "<h2>$nomeCategoria</h2>";

        foreach ($frases as $index => $frase) {

            $idAudio = "audio_" . $index . md5($nomeCategoria);

            echo "
            <button id='btn_$idAudio' onclick=\"tocarAudio('$idAudio')\">
                {$frase['texto']}
            </button>

            <audio id=\"$idAudio\" src=\"audios/{$frase['audio']}\"></audio>
        ";
        }

        echo "</div>";
    }
    ?>

    <script>
        function tocarAudio(id) {
            const audios = document.querySelectorAll("audio");
            const botoes = document.querySelectorAll("button[id^='btn_'], #botaoEmergencia");

            // Para todos os áudios e remove a classe 'tocando'
            audios.forEach(audio => {
                audio.pause();
                audio.currentTime = 0;
            });
            botoes.forEach(btn => {
                btn.classList.remove("tocando");
            });

            // Toca o áudio selecionado
            const audio = document.getElementById(id);
            audio.play();

            // Adiciona classe de feedback visual
            const btn = document.querySelector(`[onclick*="${id}"]`);
            btn.classList.add("tocando");

            // Remove a classe quando terminar
            audio.onended = () => {
                btn.classList.remove("tocando");
            };
        }
    </script>

</body>

</html>