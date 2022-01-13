// Get the modal
var modal = document.getElementById("writemodal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var trgmodal = document.getElementById("popup");

trgmodal.onclick = function(){
  modal.style.display = "block";
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}