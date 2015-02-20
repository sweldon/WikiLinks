//Temporary shitty home page javascript
$( document ).ready(function() 
{
	$( "#progress" ).hide();
	$( "#console" ).hide();


});
function fadeout(){
	$( "#pageform" ).fadeOut();
	$( "#progress" ).fadeIn();
	$( "#console" ).fadeIn();

}
function error()
{
	$( "#input-error" ).fadeIn();
}