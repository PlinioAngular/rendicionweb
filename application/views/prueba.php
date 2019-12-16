<html>
<input type="file" name="userfile" id="userfile">
<input id="alert" type="button" value="uplcargaroad"  />
</html>
<script>
  $(document).ready(function() {
    $("#alert").on('click',function(){
      $("input[name='userfile']").each(function() {
    var fileName = $(this).val().split('/').pop().split('\\').pop();
    alert(fileName);
});
    });
  });
  </script>