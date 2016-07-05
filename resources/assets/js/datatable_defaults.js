$.extend( true, $.fn.dataTable.defaults, {
    "pageLength": 25,

    language: {
        processing:     "Procesando ...",
        search:         "Buscar &nbsp;:",
        lengthMenu:     "Mostrar _MENU_ elementos",
        info:           "Mostrando del _START_ al _END_ de _TOTAL_ elementos",
        infoEmpty:      "No se han encontrado registros",
        infoFiltered:   "(De un total de _MAX_ elementos)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "No se han encontrado registros que cumplan con este filtro",
        emptyTable:     "No existen registros disponibles",
        paginate: {
            first:      "Primero",
            previous:   "Anterior",
            next:       "Siguiente",
            last:       "Último"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    }
    
} );