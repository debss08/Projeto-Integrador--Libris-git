<<<<<<< HEAD
$(document).ready(function () {
    // Barra de pesquisa

    $('#searchFor-input').on('keyup', function() {
        var termo = $(this).val().toLowerCase();

        $('.item-book,.item-emprestimo').each(function() {
        var texto = $(this).text().toLowerCase();
        $(this).toggle(texto.includes(termo));
        });
    });
=======
$(document).ready(function () {
    // Barra de pesquisa

    $('#searchFor-input').on('keyup', function() {
        var termo = $(this).val().toLowerCase();

        $('.item-book,.item-emprestimo').each(function() {
        var texto = $(this).text().toLowerCase();
        $(this).toggle(texto.includes(termo));
        });
    });
>>>>>>> c86f96261ebe2a88c6eba6787c98508ff17e56d5
});