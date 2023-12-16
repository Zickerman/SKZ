// используется для автоматического применения сортировки или фильтрации для каждого инпута формы
// (например на странице новостей или каталога)

document.addEventListener('DOMContentLoaded', function () {
    var formElements = document.getElementById('filterForm').elements;

    for (var i = 0; i < formElements.length; i++) {
        formElements[i].addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    }
});
