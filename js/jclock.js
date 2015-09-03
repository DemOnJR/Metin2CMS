  function ceas(){
    var dataCurenta = new Date ( );

    var h = dataCurenta.getHours();
    var m = dataCurenta.getMinutes();
    var s = dataCurenta.getSeconds();

    if (h<10) {h="0"+h;};
    if (m<10) {m="0"+m;};
    if (s<10) {s="0"+s;};

    var rezultat = h+':'+m+':'+s;

    document.getElementById("clock").firstChild.nodeValue = rezultat;
  }