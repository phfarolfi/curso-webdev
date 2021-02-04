function Calcular(tipo, valor) {
    if(tipo === 'acao') {
        switch(valor) {
            case 'c':
                document.getElementById('resultado').value = ''
                break;

            case '=':
                var valor_campo = document.getElementById('resultado').value
                document.getElementById('resultado').value = eval   (valor_campo)
                break;

            default:
                document.getElementById('resultado').value += valor
                break;
        }
    } else if(tipo === 'valor') {
        document.getElementById('resultado').value += valor
    }

  }