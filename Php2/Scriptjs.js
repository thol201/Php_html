$(document).ready(function(){
       document.getElementById( 'res' ).style.display = 'none';
       document.getElementById( 'res2' ).style.display = 'none';
          $('#form').submit(function(){
              
              $.ajax({
                  type: 'POST',
                  url: 'script.php',
                  data: $('#form').serialize(),
                 
              }).done(function(data){
                
                  if(data==1)
                  {
                      document.getElementById( 'res' ).style.display = 'block';
                      document.getElementById( 'res' ).textContent="Twoja Wiadomość została wysłana";
                  }
                  if(data==2)
                  {
                      document.getElementById( 'res2' ).style.display = 'block';
                      document.getElementById( 'res2' ).textContent="Wystąpił błąd podczas wysyłania wiadomości";
                  }
                  })
              event.preventDefault();
          }) 
            
        })
