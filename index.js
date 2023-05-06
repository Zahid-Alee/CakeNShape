document.getElementById("menu-toggle").addEventListener("click", function(e) {
    e.preventDefault();
    document.getElementById("wrapper").classList.toggle("toggled");
  });
  
  document.getElementById("menu-toggle-2").addEventListener("click", function(e) {
    e.preventDefault();
    document.getElementById("wrapper").classList.toggle("toggled-2");
    document.querySelectorAll("#menu ul").forEach(function(ul) {
      ul.style.display = "none";
    });
  });
  
  function initMenu() {
    document.querySelectorAll("#menu ul").forEach(function(ul) {
      ul.style.display = "none";
      if (ul.querySelector(".current")) {
        ul.parentNode.style.display = "block";
      }
    });
    document.querySelectorAll("#menu li a").forEach(function(a) {
      a.addEventListener("click", function(e) {
        var checkElement = this.nextElementSibling;
        if (checkElement && checkElement.tagName == "UL" && checkElement.style.display == "block") {
          e.preventDefault();
          return false;
        }
        if (checkElement && checkElement.tagName == "UL" && checkElement.style.display != "block") {
          e.preventDefault();
          document.querySelectorAll("#menu ul").forEach(function(ul) {
            if (ul.style.display == "block") {
              ul.style.display = "none";
            }
          });
          checkElement.style.display = "block";
          return false;
        }
      });
    });
  }
  
  document.addEventListener("DOMContentLoaded", function() {
    initMenu();
  });
  