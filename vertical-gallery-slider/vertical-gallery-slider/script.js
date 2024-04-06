jQuery(document).ready(function () {
  var mainImage = jQuery("#main-image");
  var thumbnailContainer = jQuery("#thumbnail-container .slider-wrapper");
  var slideCount = 0;
  var slideHeight = jQuery(".thumbnail").outerHeight(true);
  var slidesToShow = 4;

  jQuery(".arrow.top").click(function () {
    if (slideCount >= 0) {
      slideCount--;
      thumbnailContainer.css(
        "transform",
        "translateY(-" + slideCount * slideHeight + "px)"
      );
      updateMainImage();
    }
  });

  jQuery(".arrow.bottom").click(function () {
    if (slideCount <= thumbnailContainer.children().length - slidesToShow) {
      slideCount++;
      thumbnailContainer.css(
        "transform",
        "translateY(-" + slideCount * slideHeight + "px)"
      );
      updateMainImage();
    }
  });

  thumbnailContainer.on("click", ".thumbnail", function () {
    var thumbnailSrc = jQuery(this).attr("src");
    mainImage
      .fadeTo(500, 0.5, function () {
        mainImage.attr("src", thumbnailSrc);
      })
      .fadeTo(500, 1);
  });

  function updateMainImage() {
    var currentThumbnail = thumbnailContainer.children().eq(slideCount);
    var thumbnailSrc = currentThumbnail.attr("src");
    mainImage
      .fadeTo(500, 0.5, function () {
        mainImage.attr("src", thumbnailSrc);
      })
      .fadeTo(500, 1);
  }
});
