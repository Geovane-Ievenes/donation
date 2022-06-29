<!-- This input has to be sent in a HTML form-->
<input type="hidden" name="sliders-count" id="sliders-count">
<div class="slideshow-container">

  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>

  <div class="mySlides fade" id="0">
    <img src="./1.jpg" class="image" style="width:550px; height: 400px">
  </div>

</div>
<br>

<div style="text-align:center" class="dots-container">
  <span class="dot" onclick="currentSlide(1)"></span> 
</div>

<div class="input-file-container">
  <input type="file" name="file0" id="0" accept="image/png,image/jpeg,image/jpg" onchange="createNewSliderIndex(this)">
</div>