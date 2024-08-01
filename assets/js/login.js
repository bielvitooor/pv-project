// Função para obter parâmetros da URL
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Exibir mensagem de erro se houver
document.addEventListener('DOMContentLoaded', function() {
    var error = getUrlParameter('error');
    var errorMessage = '';

    switch (error) {
        case '1':
            errorMessage = "Usuário ou senha incorretos. Tente novamente.";
            break;
        case '2':
            errorMessage = "Sua conta está desativada. Entre em contato com o suporte.";
            break;
        default:
            errorMessage = "Ocorreu um erro durante o login.";
            break;
    }

    if (errorMessage) {
        document.getElementById('error-message').textContent = errorMessage;
    }
});
