<!-- This input has to be sent in a HTML form-->
<input type="hidden" name="sliders-count" id="sliders-count">

<div class="slideshow-container">

  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
    <?php 
      $sql_s = 'SELECT * FROM tbimagens WHERE id_projeto_imagem = '. $project;
      $result_img = mysqli_query($connection, $sql_s);
      if(!$result_img){
        die('Não foi possível buscar o banco de imagens do projeto, desculpe :(');
      }

      $dot_Qtd = 0;
      while($reg_img_show = mysqli_fetch_assoc($result_img)){
        echo('
        <div class="mySlides fade" id="'.($dot_Qtd).'">
          <span class="material-icons-outlined delete" style="font-size: 45px;" onclick="removeImage(this.parentNode)">delete</span>
          <img src="./fotos_projeto/'.$reg_img_show['imagem_projeto'].'" class="image" style="width:550px; height: 400px">
        </div>
        ');
        $dot_Qtd++;
      }
    ?>
</div>
<br>

<div style="text-align:center" class="dots-container">
  <?php 
    for($z = 1; $z <= $dot_Qtd; $z++){
      echo('<span class="dot" onclick="currentSlide('.$z.')" id="'.$z.'"></span>');
    }
  ?>
  
</div>

<div class="input-file-container">  
  <?php 
    for($e = 1; $e <= $dot_Qtd; $e++){
      echo('
        <input type="file" name="img_slide"'.($e - 1).'" id="file.'.($e - 1).'" accept="image/png,image/jpeg,image/jpg" onchange="createNewSliderIndex(this)" style="display: none;">
        <label for="file.'.($e - 1).'" class="img_slide" id="'.($e - 1).'" style="display: none;">Inserir Fotos</label>');
    }
    echo('
      <input type="file" name="file'.($e - 1).'" id="file.'.($e - 1).'" accept="image/png,image/jpeg,image/jpg" onchange="createNewSliderIndex(this)" style="display: none;">
      <label for="file.'.($e - 1).'" class="img_slide" id="'.($e - 1).'">Inserir Fotos</label>');
  ?>
</div>

<!--Just for edit project system-->
<input type="hidden" name="qtd_sliders" id="qtd_sliders" value="<?php echo($dot_Qtd);?>">

<script src="./js/general-validation.js"></script>
<script src="./js/file-validation.js"></script>

