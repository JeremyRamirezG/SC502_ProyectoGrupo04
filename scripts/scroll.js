document.addEventListener('DOMContentLoaded', function() {
    var miObjeto = document.getElementById('lista__nav');
    var lastScrollTop = 0;
  
    window.addEventListener('scroll', function() {
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
      if (window.innerWidth <= 1500) {
        if (scrollTop === 0) {
            // El usuario está en la parte superior de la página
            miObjeto.style.transform = 'translateY(0)';
          } else {
            // El usuario está haciendo scroll hacia arriba
            miObjeto.style.transform = 'translateY(-100%)';
          }
      } else {
        miObjeto.style.transform = 'translateY(0)';
      }
  
      lastScrollTop = scrollTop;
    });
  });

  function displayFileName() {
    const fileInput = document.getElementById('avatar');
    const fileNameSpan = document.getElementById('fileName');
  
    if (fileInput.files.length > 0) {
      fileNameSpan.textContent = fileInput.files[0].name;
    } else {
      fileNameSpan.textContent = '';
    }
  }