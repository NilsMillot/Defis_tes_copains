$(document).ready( function () {
    $('#challenge_view').DataTable( {
        select: true,
        "language": {    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json",  },
        "pageLength": 20,
        responsive: true,
        dom: 'rtip',
    });
} );