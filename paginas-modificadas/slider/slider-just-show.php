<div class="show-img-slider">
  <!-- This input has to be sent in a HTML form-->
  <input type="hidden" name="sliders-count" id="sliders-count">

  <div class="slideshow-container">

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
      <?php 
          $dot_Qtd = 0;
          foreach($img_existentes as $img_ex){
            echo('
            <div class="mySlides" id="'.($dot_Qtd).'"> 
              <img src="'.$rota_imagens.'/'.$img_ex.'" class="image" style="width:350px; height: 300px">
            </div>
            ');
            $dot_Qtd++;
          }
          
          foreach($img_novas as $img_nv){
            echo('
            <div class="mySlides" id="'.($dot_Qtd).'">
              <img src="'.$rota_imagens.'/'.$img_nv.'" class="image" style="width:350px; height: 300px">
            </div>
            ');
            $dot_Qtd++;
          }
      ?>
  </div>

  <div style="text-align:center" class="dots-container">
    <?php 
      for($z = 1; $z <= $dot_Qtd; $z++){
        echo('<span class="dot" onclick="currentSlide('.$z.')"></span>');
      }
    ?>
  </div>

  <!--Just for edit project system-->
  <input type="hidden" name="qtd_sliders" id="qtd_sliders" value="<?php echo($dot_Qtd);?>">
</div>