<!-- This input has to be sent in a HTML form-->
<input type="hidden" name="sliders-count" id="sliders-count">

<div class="slideshow-container">

  <a class="prev2" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next2" onclick="plusSlides(1)">&#10095;</a>
    <?php 
        $dot_Qtd = 0;

        foreach($img_apagadas as $img_apg){
          echo('
          <div class="mySlides2" id="'.($dot_Qtd).'">
            <img src="../solicitacoes_mod/'.$img_apg.'" class="image" style="width:350px; height: 300px">
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
      echo('<span class="dot2" onclick="currentSlide2('.$z.')"></span>');
    }
  ?>
</div>

<!--Just for edit project system-->
<input type="hidden" name="qtd_sliders" id="qtd_sliders" value="<?php echo($dot_Qtd);?>">