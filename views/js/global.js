$(document).ready(function () {
    // Barra de pesquisa

    $('#searchFor-input').on('keyup', function() {
        var termo = $(this).val().toLowerCase();

        $('.item-book,.item-emprestimo').each(function() {
        var texto = $(this).text().toLowerCase();
        $(this).toggle(texto.includes(termo));
        });
    });

    // Abrir modal para cadastrar categoria

    function abrirModal(){
        $("#modalCategoria").show();
    }

    function fecharModal(){
        $("#modalCategoria").hide();
    }
});