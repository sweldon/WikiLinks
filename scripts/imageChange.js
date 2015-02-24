$(document).ready(function () {

	$('#pageform').css("background-image", "url(images/wikipedia.png)");  

$('#realm').click(function()
{
var realm = $( "#realm option:selected" ).text();

if(realm == "General (Wikipedia)")
{
	$('#pageform').css("background-image", "url(images/wikipedia.png)");  
}
else if(realm == "Game of Thrones (Soon)")
{
	$('#pageform').css("background-image", "url(images/got.jpg)"); 

}
else
{
	$('#divID').css("background-color", "gray");  
}

});
});