// Armazenar a altura e a largura da página em duas variáveis
var altura = window.innerHeight
var largura = window.innerWidth

// Variável que representa qual vida vai ser removida na função posicaoAleatoria()
var vidas = 1

// Variáveis que controlam o tempo de jogo e o tempo que o mosquito fica na tela
var tempo_mosquito = 1500
var tempo = 10

// Variável que recebe o nível do jogo
var nivel = window.location.search
nivel = nivel.replace('?', '')

if(nivel === 'normal'){
    tempo_mosquito = 1500
    tempo = 15
} else if (nivel === 'dificil'){
    tempo_mosquito = 1000
    tempo = 20
} else if (nivel === 'chucknorris'){
    tempo_mosquito = 750
    tempo = 30
}

var cronometro = setInterval(function(){
    tempo--

    if(tempo < 0){
        window.location.href = 'vitoria.html'
    }

    document.getElementById('cronometro').innerHTML = tempo
}, 1000)

function AjustarJanela() {
    altura = window.innerHeight
    largura = window.innerWidth
}

// Criar o elemento mosquito na tela
function posicaoAleatoria(){
    //Remove o mosquito anterior (caso exista)
    if(document.getElementById('mosquito')) {
        document.getElementById('mosquito').remove()

        if(vidas > 3){
             window.location.href = 'derrota.html'
        }

        document.getElementById('v' + vidas).src = "imagens/coracao_vazio.png"
        vidas++
    }

    // Utilizar a função Math.random() para gerar valores aleatórios para os mosquitos
    var posicaoX = Math.floor(Math.random()*largura) - 100
    var posicaoY = Math.floor(Math.random()*altura) - 100

    //Impede que o mosquito apareça fora da tela
    posicaoX = posicaoX < 0 ? 0 : posicaoX
    posicaoY = posicaoY < 0 ? 0 : posicaoY

    //Cria o elemento mosquito em uma posição aleatória da tela
    var mosquito = document.createElement('img')
    mosquito.src = 'imagens/mosquito.png'
    mosquito.style.left = posicaoX + 'px'
    mosquito.style.top = posicaoY + 'px'
    mosquito.style.position = 'absolute'
    mosquito.id = 'mosquito'
    mosquito.onclick = function(){
        this.remove()
    }

    // Variáveis criadas para escolher aleatoriamente as classes do mosquito (pequeno/médio/grande) e (olhando pra esquerda/olhando para a direita)
    var classe = Math.floor(Math.random()*3) + 1
    var lado = Math.floor(Math.random()*2) + 1
    lado = lado == 1 ? 'ladoA' : 'ladoB'
    mosquito.className = 'mosquito' + (classe) + ' ' + (lado)

    //Mostra o mosquito na tela
    document.body.appendChild(mosquito)
}