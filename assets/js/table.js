$(document).ready(function() {
    $('#overzicht').DataTable( {
        "language": {
          "emptyTable": "Geen data gevonden",
          "zeroRecords": "Er is niets gevonden dat voldoet aan de zoekcriteria",
          "sInfo": "Showing _START_ to _END_ of _TOTAL_ records",
        },
        dom: 'lBfrtip', 
        // buttons: ['columnsToggle'],
        buttons: [ {
          extend: 'colvis',
          columnText: function ( dt, idx, title ) {
              return (idx+1)+': '+title;
          }
        } ],
        aLengthMenu: [
          [10, 25, 50, 100, 150, -1],
          [10, 25, 50, 100, 150, "All"]
        ]
    });

    $("#csv-file-exp").click(function(){
      $("#overzicht").table2excel({  
          exclude: ".noExl",   // exclude CSS class
          name: "Worksheet Name",
          filename: "overzicht", //do not include extension
          fileext: ".xls" // file extension
      }); 
    });
    
});
