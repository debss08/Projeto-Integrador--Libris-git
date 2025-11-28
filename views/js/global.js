$(document).ready(function () {
    // Barra de pesquisa

    $('#searchFor-input').on('keyup', function() {
        var termo = $(this).val().toLowerCase();

        $('.item-book,.item-emprestimo').each(function() {
        var texto = $(this).text().toLowerCase();
        $(this).toggle(texto.includes(termo));
        });
    });
});