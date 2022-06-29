const dotsContainer = document.querySelector('.dots-container');
const slideshow = document.querySelector('.slideshow-container');
const fileInputsCotainer = document.querySelector('.input-file-container');
const SubmitSlidersCount = document.querySelector('#sliders-count');
const SliderModStatus = document.querySelector('#slider-mod');
const SliderAddStatus = document.querySelector('#slider-add');
const SliderRmStatus = document.querySelector('#slider-rmv'); 

var LastImageIndex = (document.querySelector('#qtd_sliders').value - 1);
var slideIndex = 1;
var slidersCount = document.querySelector('#qtd_sliders').value; 
var newSlidersCount = 0;

var imgRemoved = [];

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
  var fileInputId = parseInt(FileInput.id.split('.')[1]);

  if(fileInputId == '0') FileStatus[0] = 'valid';
  else FileStatus.push('valid'); //If validarArquivo return false, this valid status will be removed....
  
  if(!validarArquivo(FileInput, parseInt(fileInputId) , 'image', 'popup')){
    if(fileInputId == '0') FileStatus[0] = 'invalid'; // here
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
  console.log(inputFile.id.split('.')[1]);
  var newImageInputIndex = parseInt(inputFile.id.split('.')[1]); //Mesmo id do inout file //danesse

  // EDIT-PROJET ONLY
  newSlidersCount++;

  SliderModStatus.value = "true"; 

  if(!pendingRequest) submitInput.disabled = false;

  submitInput.value = 'Solicitar modificação';
  requestStatus.value = 'true';

  //CHANGE JUST THE FIRST IMAGE SOURCE
  if(newImageInputIndex == 0){
    let currentSlide = document.querySelector('.mySlides');
    let fisrtImage = currentSlide.querySelector('img');

    fisrtImage.setAttribute('src', imageURL);

    let trashHtmlString = `<span class="material-icons-outlined delete" style="font-size: 45px;" onclick="removeImage(this.parentNode)">delete</span>`;
    let trashDoc = new DOMParser().parseFromString(trashHtmlString , "text/html");
    let newtrashIcon = trashDoc.querySelector('.delete');
    currentSlide.appendChild(newtrashIcon);
  }

  else{ //ADD ANOTHER SLIDE SHOW ELEMENT
      /*Add Slider Div*/
    let sliderHtmlString = `<div class="mySlides fade" id="${++LastImageIndex}"><span class="material-icons-outlined delete" style="font-size: 45px;" onclick="removeImage(this.parentNode)">delete</span> <img src="${imageURL}" class="image" style="width:550px; height: 400px"></div>`;
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

  var inputHtmlString = `<input type="file" name="file${newInputFileId}" accept="image/png,image/jpeg,image/jpg" class="input-file" id="file.${newInputFileId}" onchange="createNewSliderIndex(this)"><label for="file.${newInputFileId}" class="img_slide" id="${newInputFileId}">Inserir Fotos</label>`;
  var inputDoc = new DOMParser().parseFromString(inputHtmlString, "text/html");
  var nextFileInput = inputDoc.querySelector('.input-file');  
  fileInputsCotainer.appendChild(nextFileInput);

    //Create a new label to add next image in ANY SITUATION
  let labelHtmlString = `<label for="file.${newInputFileId}" class="img_slide" id="${newInputFileId}">Inserir Fotos</label>`;
  let labelDoc = new DOMParser().parseFromString(labelHtmlString, "text/html");
  let nextLabel = labelDoc.querySelector('.img_slide');  
  fileInputsCotainer.appendChild(nextLabel);

    /*hide previus input file and labels*/
  let allFileInputs = document.querySelectorAll('.input-file-container input[type=file]');
  let allLabels = document.querySelectorAll('.img_slide');

    /*Hide previous input*/ 
    console.log(allFileInputs);
    console.log(newImageInputIndex);
  allFileInputs[newImageInputIndex].style = 'display: none'   

    /*Hide previous label*/ 
  allLabels[newImageInputIndex].style = 'display: none';

  currentSlide(newImageInputIndex + 1);
}

function removeImage(ImageSlide){
  var slideId = parseInt(ImageSlide.id);
  var slideImgSrc = ImageSlide.querySelector('.image').src;
  var decreaseLastSlideIndex = true;
  var newInputFileId = slideId;

  // EDIT-PROJET ONLY
  requestStatus.value = 'true';
  SliderModStatus.value = "true"; 
  SliderRmStatus.value = 'true';
  
  if(!pendingRequest) submitInput.disabled = false;

  submitInput.value = 'Solicitar modificação';
  
  const allSlides = document.querySelectorAll('.mySlides'),
        allDots = document.querySelectorAll('.dot'),
        allFileInputs = document.querySelectorAll('.input-file-container input[type=file]'),
        allLabels = document.querySelectorAll('.img_slide');
        
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
    allLabels[slideId + 1].remove();
    
    var UpdatedAllFileInputs = document.querySelectorAll('.input-file-container input[type=file]');

    //delete the file input that was reserved to the deleted image
    allFileInputs[slideId].remove(); 
    allLabels[slideId].remove();
    
    //Add new input file to replace the old one
    let inputHtmlString = `<input type="file" name="file.${slideId}" accept="image/png,image/jpeg,image/jpg" class="input-file" id="file.${slideId}" onchange="createNewSliderIndex(this)">`;
    let inputDoc = new DOMParser().parseFromString(inputHtmlString, "text/html");
    let nextFileInput = inputDoc.querySelector('.input-file');  
    fileInputsCotainer.appendChild(nextFileInput);

    //Add new label to replace the old one
    let labelHtmlString = `<label for="file.${newInputFileId}" class="img_slide" id="${newInputFileId}">Inserir Fotos</label>`;
    let labelDoc = new DOMParser().parseFromString(labelHtmlString, "text/html");
    let nextLabel = labelDoc.querySelector('.img_slide');  
    fileInputsCotainer.appendChild(nextLabel);

    currentSlide(slideId) // Get the previous slide
  }
  else{
    allFileInputs[slideId].remove();
    allLabels[slideId].remove();

    var UpdatedAllFileInputs = document.querySelectorAll('.input-file-container input[type=file]');
    var UpdatedAllLabels = document.querySelectorAll('.img_slide');

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
      UpdatedAllFileInputs[countPositionFiles].id = 'file.' + countPositionFiles;
      UpdatedAllFileInputs[countPositionFiles].setAttribute('name', `file${countPositionFiles}`);

      UpdatedAllLabels[countPositionFiles].id = 'file.' + countPositionFiles;
      UpdatedAllLabels[countPositionFiles].setAttribute('name', `file${countPositionFiles}`);
    }

    currentSlide(slideId + 1) // Get the slide in the same position
  }

  if(decreaseLastSlideIndex) LastImageIndex--;
    slidersCount--;

  //EDIT PROJECT ONLY
  if(slideImgSrc.indexOf('blob:') == -1){
    let srcSliced = slideImgSrc.split('/').slice(-1)[0]; //Push just the img name to array 

    imgRemoved.push(srcSliced); 
  }
  else{
    newSlidersCount++;  
  }
} 