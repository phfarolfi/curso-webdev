// Armazenar a altura e a largura da página em duas variáveis
var altura = window.innerHeight
var largura = window.innerWidth

function AjustarJanela() {
    altura = window.innerHeight
    largura = window.innerWidth

    console.log(largura, altura)
}


// Criar o elemento mosquito
function posicaoAleatoria(){
    // Utilizar a função Math.random() para gerar valores aleatórios para os mosquitos
    var posicaoX = Math.floor(Math.random()*largura) - 100
    var posicaoY = Math.floor(Math.random()*altura) - 100

    posicaoX = posicaoX < 0 ? 0 : posicaoX
    posicaoY = posicaoY < 0 ? 0 : posicaoY

    console.log(posicaoX, posicaoY)

    var mosquito = document.createElement('img')
    mosquito.src = 'imagens/mosquito.png'
    mosquito.className = 'mosquito1'
    mosquito.style.left = posicaoX + 'px'
    mosquito.style.top = posicaoY + 'px'
    mosquito.style.position = 'absolute'
    mosquito.style.width = Math.floor(Math.random()*70) + 'px'
    mosquito.style.height = Math.floor(Math.random()*70) + 'px'

    document.body.appendChild(mosquito)
}