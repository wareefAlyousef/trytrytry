document.addEventListener('DOMContentLoaded', function() {
  var categorySelect = document.getElementById('category');
  var filterButton = document.getElementById('filter');
  var designersContainer = document.querySelector('.designers');
  var designers = document.querySelectorAll('.designer');

  filterButton.addEventListener('click', function() {
      var selectedCategory = categorySelect.value.toLowerCase();

      designers.forEach(function(designer) {
          var designPreferences = Array.from(designer.querySelectorAll('.specialty .preference')).map(function(pref) {
              return pref.textContent.toLowerCase();
          });
          var showDesigner = (selectedCategory === 'all' || designPreferences.includes(selectedCategory));
        
          designer.style.display = showDesigner ? 'block' : 'none';
      });
  });
});





document.addEventListener('DOMContentLoaded', function() {
  var totalImages = 3; 

  var sliderContainers = document.querySelectorAll('.slider-container');
  var prevButtons = document.querySelectorAll('#prevBtn');
  var nextButtons = document.querySelectorAll('#nextBtn');

  sliderContainers.forEach(function(sliderContainer, index) {
    var currentIndex = 0;
    var imageWidth = sliderContainer.offsetWidth;

    function prevSlide() {
      currentIndex = (currentIndex - 1 + totalImages) % totalImages;
      updateSlider();
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalImages;
      updateSlider();
    }

    function updateSlider() {
      var newPosition = -currentIndex * imageWidth + 'px';
      sliderContainer.querySelector('.slider-wrapper').style.transform = 'translateX(' + newPosition + ')';
    }

    prevButtons[index].addEventListener('click', prevSlide);
    nextButtons[index].addEventListener('click', nextSlide);
  });
});