<script>
   //Jquery begins!
   $(document).ready(function() {
      console.log('liisto');

      //first, we add all neccesary variables, first one is for fill with ajax called paises
      var paises = '';
      //this one is number of elements seeing in list
      var elementos = 3;
      //this number of columns used in data table
      var columnas = 3;
      //this is the num total values 
      var total = '214';

      //here we calculate the page total number
      var totalPaginas = Math.floor(total / elementos) + 1;
      //here we add the number in div id="pag" according to all pages for data
      for (var i = 1; i <= totalPaginas; i++) {
         $('#pag').append('<a href="#pag-' + i + '" class="idpagination" id="' + i + '"><p>' + i + '</p></a><p>&nbsp;&nbsp; </p>');
      }

      //We call al info for ajax (the header because the page is in laravel)
      $.ajax({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         type: 'POST',
         data: {
            idpais: '',
            idestado: ''
         },
         url: 'ajax_paises',
         success: function(response) {
            //we add the result in variable paises
            paises = response;
            //console.log(paises['participantes']);
            //console.log(paises['participantes'][0]);
            //console.log(paises['participantes'][0]['id']);
         }
      })
      //When you click another page
      $('.idpagination').click(function() {
         //we calculate the max and min value about visible data
         var max = this.id * elementos;
         var min = this.id * elementos - (elementos - 1);

         //number or loops for doing inside
         var vueltas = 1;
         /*Is necessary specify that here we consider a table like
         <table>
         <tr id="tr1">
         <td id="11"></td>
         <td id="12"></td>
         <td id="13"></td>
         </tr>
         <tr id="tr2">
         <td id="21"></td>
         <td id="22"></td>
         <td id="23"></td>
         </tr>
         ...
         <tr id="tr(n)">
         <td id="(n)(m)"></td>
         <td id="(n)(m+1)"></td>
         <td id="(n)(m+2)"></td>
         </tr>
         </table>
         */
         for (i = min; i <= max; i++) {
            //if i is more than total, then we remove the column but no agree a new one
            if (i <= total) {
               //this second one is for add each column in a row
               for (j = 1; j <= columnas; j++) {
                  //we remove and old <td>
                  $('#td' + vueltas + j).remove();
                  //this switch is only for three, but we can add the neccesary options here
                  switch (j) {
                     //id case
                     case 1:
                        var id = paises['participantes'][i - 1]['id'];
                        $('#tr' + vueltas).append('<td id="td' + vueltas + j + '">' + id + '</td>');
                        break;
                     //name country
                     case 2:
                        var nombre = paises['participantes'][i - 1]['nombre'];
                        $('#tr' + vueltas).append('<td id="td' + vueltas + j + '">' + nombre + '</td>');
                        break;
                     //anothe column (in this case, total values)
                     case 3:
                        $('#tr' + vueltas).append('<td id="td' + vueltas + j + '">'+total+'</td>');
                        break;
                     default:
                        console.log('Error!!!, el valor de j es:' + j);
                  }

               }

            } else {
               for (j = 1; j <= columnas; j++) {
                  $('#td' + vueltas + j).remove();
               }
            }
            vueltas++;

         }
      });
   });
</script>