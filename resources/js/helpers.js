// использую для автоматического применения сортировки(например на странице новостей)
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('order_by').addEventListener('change', function () {
        document.getElementById('filterForm').submit();
    });
});
