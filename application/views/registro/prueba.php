<?php echo form_open_multipart('deposito/do_upload');  ?>
<?= $error; ?>
<div class="file-input-wrapper">
  <button class="btn-file-input">Upload File</button>
  <input type="file" id="userfile" name="userfile" />
</div>
<input type="submit" value="upload" />
<input type="text" name="ruta" id="ruta" />
<input id="alert" type="button" value="uplcargaroad" />
</form>
<style>
  .file-input-wrapper {
    width: 200px;
    height: 40px;
    overflow: hidden;
    position: relative;
  }
  .file-input-wrapper > input[type="file"] {
    font-size: 200px;
    position: absolute;
    top: 0;
    right: 0;
    opacity: 0;
  }
  .file-input-wrapper > .btn-file-input {
    display: inline-block;
    width: 200px;
    height: 40px;
  }
  </style>
  
  <script>
  $(document).ready(function() {
    $("#alert").on('click',function(){
        var x = document.getElementById("userfile").value;
        $("#ruta").val(x);
    });
  });
  </script>