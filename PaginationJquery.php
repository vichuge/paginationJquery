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
      $('.idpagination').click(function() {

         var max = this.id * elementos;
         var min = this.id * elementos - (elementos - 1);

         var vueltas = 1;
         for (i = min; i <= max; i++) {
            var total = '{{$total[0]->total}}'
            if (i <= total) {
               for (j = 1; j <= columnas; j++) {
                  $('#td' + vueltas + j).remove();
                  switch (j) {
                     case 1:
                        var id = paises['participantes'][i - 1]['id'];
                        $('#tr' + vueltas).append('<td id="td' + vueltas + j + '">' + id + '</td>');
                        break;
                     case 2:
                        var nombre = paises['participantes'][i - 1]['nombre'];
                        $('#tr' + vueltas).append('<td id="td' + vueltas + j + '">' + nombre + '</td>');
                        break;
                     case 3:
                        $('#tr' + vueltas).append('<td id="td' + vueltas + j + '">{{$total[0]->total}}</td>');
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