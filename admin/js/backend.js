/////////////////////////////////////////

// trigger select box


  $("select").selectBoxIt({

     theme: "jqueryui",
     
     showEffect: "shake",

    // Sets the animation speed to 'slow'
    showEffectSpeed: 'slow',

    // Sets jQueryUI options to shake 1 time when opening the drop down
    showEffectOptions: { times: 1 },

    // Uses the jQueryUI 'explode' effect when closing the drop down
    hideEffect: "explode"

  






  });


/////////////////////////////////////////////




var link = document.getElementsByClassName('child-link');

for(var i=0;i<link.length;i++)

if(link[i]) {

link[i].onmouseover = function () {

     this.children[1].style.display = 'inline';
}

link[i].onmouseout = function () {

     this.children[1].style.display = 'none';
}
}

/////////////////////////////////////////////////////////////////










// Make confirm message 




var conf = document.getElementsByClassName('confirm');


/*conf.onclick = function() {

  return confirm("are you sure ? ");
}*/

for(var i = 0 ;i<conf.length;i++ ) {

if(conf[i]){

conf[i].onclick = function() {


  return confirm("are you sure ? ");

  }

}

}



//////////////////////////////////////////////////////////////////////////



var input = document.getElementsByClassName('form-control');

//alert(input.length);
//input[0].value="*";

// Add  red star required elements

for(var i=0;i<input.length;i++) {


    if(input[i].hasAttribute('required')) {

    
    var elem = document.createElement("span");
    
    elem.classList.add('star');

     var text = document.createTextNode("*");

     elem.appendChild(text);



     input[i].after(elem);

   }
    else {

    	continue;
    }


}

///////////////////////////////////////////////////

// make show icon to show password


var pass = document.getElementsByClassName('password');
var show = document.getElementsByClassName('show');

if(show[0]) {
show[0].onmouseover =function () {
	
      pass[0].setAttribute('type','text');
}
show[0].onmouseout =function () {
	
      pass[0].setAttribute('type','password');
}

}

////////////////////////////////////////////////////////////










//////////////////////////// using panel Icon 





