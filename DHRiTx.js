    function gg2(){
       var c = document.getElementById('hhuuiii').value;
       up = "https://www.google.co.in/search?q="+c;
       window.open(up);
    }
    let follow = document.getElementById('follow');
    follow.addEventListener("click", function () {
       follow.innerText = "Followed";
    });
