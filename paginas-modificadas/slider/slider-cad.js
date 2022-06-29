const slideshow = document.querySelector('.slideshow-container');
const dotsContainer = document.querySelector('.dots-container');
const fileInputsCotainer = document.querySelector('.input-file-container');
const SubmitSlidersCount = document.querySelector('#sliders-count');

var LastImageIndex = 0;
var slideIndex = 1;
var slidersCount = 0; 

showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}

//Customize Slider
function createNewSliderIndex(FileInput){
  if(FileInput.id == '0') FileStatus[0] = 'valid';
  else FileStatus.push('valid'); //If validarArquivo return false, this valid status will be removed....
  
  if(!validarArquivo(FileInput, parseInt(FileInput.id) , 'image', 'popup')){
    if(FileInput.id == '0') FileStatus[0] = 'invalid'; // here
    else FileStatus.pop(); // or here
    
    return false;
  }

  slidersCount++;
  const file = FileInput.files[0];

  if(typeof file != 'undefined'){
    return new Promise((resolve, reject)=>{ 
      let ImageURL = URL.createObjectURL(file)
      addImage(ImageURL, FileInput);
    })
  }
}

function addImage(imageURL, inputFile){
  var newImageInputIndex = parseInt(inputFile.id); //Mesmo id do inout file

  $('.error-message[id=slider]').html('');

  //CHANGE JUST THE FIRST IMAGE SOURCE
  if(newImageInputIndex == 0){
    let currentSlide = document.querySelector('.mySlides');
    let fisrtImage = currentSlide.querySelector('img');

    fisrtImage.setAttribute('src', imageURL);

    let trashHtmlString = `<img src="./trash.png" alt="Apagar Imagem" class="delete" width="30px" height="30px" onclick="removeImage(this.parentNode)">`;
    let trashDoc = new DOMParser().parseFromString(trashHtmlString , "text/html");
    let newtrashIcon = trashDoc.querySelector('.delete');
    currentSlide.appendChild(newtrashIcon);
  }

  else{ //ADD ANOTHER SLIDE SHOW ELEMENT
      /*Add Slider Div*/
    let sliderHtmlString = `<div class="mySlides fade" id="${++LastImageIndex}"><span class="material-icons-outlined delete" style="font-size: 45px;" onclick="removeImage(this.parentNode)">delete</span><img src="${imageURL}" class="image" style="width:550px; height: 400px"></div>`;
    let sliderDoc = new DOMParser().parseFromString(sliderHtmlString , "text/html");
    let newSlider = sliderDoc.querySelector('.mySlides');
    slideshow.appendChild(newSlider);

      /*dot*/
    let dotHtmlString = `<span class="dot" onclick="currentSlide(${newImageInputIndex + 1})" id="${newImageInputIndex + 1}"></span> `;
    let dotDoc = new DOMParser().parseFromString(dotHtmlString, "text/html");
    let newDot = dotDoc.querySelector('.dot');
    dotsContainer.appendChild(newDot);
  }

      // Create a new input file to add next image in ANY SITUATION*/
  let newInputFileId = newImageInputIndex + 1;

  var inputHtmlString = `<input type="file" name="file${newInputFileId}" accept="image/png,image/jpeg,image/jpg" class="input-file" id="${newInputFileId}" onchange="createNewSliderIndex(this)">`;
  var inputDoc = new DOMParser().parseFromString(inputHtmlString, "text/html");
  var nextFileInput = inputDoc.querySelector('.input-file');  
  fileInputsCotainer.appendChild(nextFileInput);

    /*hide previus input file*/
  let allFileInputs = document.querySelectorAll('.input-file-container input[type=file]');
  allFileInputs[newImageInputIndex].style = 'display: none' //Apagar o input que correspondia a essa imagem nova

  currentSlide(newImageInputIndex + 1)
}

function removeImage(ImageSlide){
  var slideId = parseInt(ImageSlide.id);
  var decreaseLastSlideIndex = true;
  
  const allSlides = document.querySelectorAll('.mySlides'),
        allDots = document.querySelectorAll('.dot'),
        allFileInputs = document.querySelectorAll('.input-file-container input[type=file]');

  if(LastImageIndex == 0){
    let image = ImageSlide.querySelector('.image');

    image.setAttribute('src', './1.jpg'); //change img src
    ImageSlide.querySelector('.delete').remove(); //remove trash icon

    decreaseLastSlideIndex = false; //Didn't decrease any slide, just switched the first one src
  }
  else{
    ImageSlide.remove();
    var UpdatedAllSlides = document.querySelectorAll('.mySlides');

    allDots[slideId].remove();
    var UpdatedAllDots = document.querySelectorAll('.dot');
  }

  if(slideId == LastImageIndex){ //if slide index is 0 or not
    allFileInputs[slideId + 1].remove();  
    var UpdatedAllFileInputs = document.querySelectorAll('.input-file-container input[type=file]');

    //delete the file input that was reserved to the deleted image
    allFileInputs[slideId].remove(); 
    
     //Add new input file to replace the old one
    let inputHtmlString = `<input type="file" name="file${slideId}" accept="image/png,image/jpeg,image/jpg" class="input-file" id="${slideId}" onchange="createNewSliderIndex(this)">`;
    let inputDoc = new DOMParser().parseFromString(inputHtmlString, "text/html");
    let nextFileInput = inputDoc.querySelector('.input-file');  
    fileInputsCotainer.appendChild(nextFileInput);

    currentSlide(slideId) // Get the previous slide
  }
  else{
    allFileInputs[slideId].remove();
    var UpdatedAllFileInputs = document.querySelectorAll('.input-file-container input[type=file]');

    for(let countPosition = slideId; countPosition < UpdatedAllSlides.length; countPosition++){
      let newIdString = countPosition.toString(); 

      UpdatedAllSlides[countPosition].id =  countPosition;

      UpdatedAllDots[countPosition].remove();
      let replaceDotHtmlString = `<span class="dot" onclick="currentSlide(${countPosition + 1})" id="${countPosition + 1}"></span> `;
      let replaceDotDoc = new DOMParser().parseFromString(replaceDotHtmlString, "text/html");
      let newDot = replaceDotDoc.querySelector('.dot');

      if(countPosition == 0) $('.dots-container').append(newDot);
      else $(newDot).insertAfter($(`.dot[id='${countPosition}']`));
    }

    for(let countPositionFiles = slideId; countPositionFiles < UpdatedAllSlides.length + 1; countPositionFiles++){
      UpdatedAllFileInputs[countPositionFiles].id = countPositionFiles;
      UpdatedAllFileInputs[countPositionFiles].setAttribute('name', `file${countPositionFiles}`);
    }

    currentSlide(slideId + 1) // Get the slide in the same position
  }

  if(decreaseLastSlideIndex) LastImageIndex--;
  slidersCount--;
}