var interval = 2; // delay between rotating images (in seconds)
var random_display = 1; // 0 = no, 1 = yes
interval *= 1000;

var image_index = 0;
image_list = new Array();

//image_list[image_index++] = new imageItem("images/aralaw3.jpg");
//image_list[image_index++] = new imageItem("images/sequoia1.jpg");
//image_list[image_index++] = new imageItem("images/UVnew.jpg");
//image_list[image_index++] = new imageItem("images/2kpmg1-new.jpg");
// image_list[image_index++] = new imageItem("images/Trilegal_1.jpg");

//image_list[image_index++] = new imageItem("images/techholding.png");
//image_list[image_index++] = new imageItem("images/sequoia1.jpg");
image_list[image_index++] = new imageItem("images/basiz.jpg");
image_list[image_index++] = new imageItem("images/avalon_1.jpg");
//image_list[image_index++] = new imageItem("images/jsa.jpg");
image_list[image_index++] = new imageItem("images/tatva_small.png");
image_list[image_index++] = new imageItem("images/ELP.png");
image_list[image_index++] = new imageItem("images/spark_logo.png");

//image_list[image_index++] = new imageItem("images/headland_index.gif");
//image_list[image_index++] = new imageItem("images/ic-logo1.jpg");
//image_list[image_index++] = new imageItem("images/o3capital_1.jpg");


var number_of_image = image_list.length;

function imageItem(image_location) {
this.image_item = new Image();
this.image_item.src = image_location;
}
function get_ImageItemLocation(imageObj) {
return(imageObj.image_item.src)
}
function generate(x, y) {
var range = y - x + 1;
return Math.floor(Math.random() * range) + x;
}
function getNextImage() {
if (random_display) {
image_index = generate(0, number_of_image-1);
}
else {
image_index = (image_index+1) % number_of_image;
}
var new_image = get_ImageItemLocation(image_list[image_index]);
return(new_image);
}
