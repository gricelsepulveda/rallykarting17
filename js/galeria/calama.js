$(function(){
  'use strict';
  var getFaceBookpic = function() {
  /*************************************************************
  * Get json
  **************************************************************/
    $.getJSON('https://graph.facebook.com/1670446493234660/photos/?fields=images&access_token=EAADtrhgW99cBALYUx8Khr3VLV8uD3ZCvkNnliQgIyGFJe6eSP9efcFcy6HzqScFamG8KQREyz8sG6pfqXZCgiKLmXnpSGAUpnrxZCN8g5mrCiEwHOw5BtfPASOB1N1GuBeZAz9tGqVtwsAppo5V0rGJk9LdlYnYjpZAJaK5ftUQZDZD', function(json){
      var
      getPhotoCnt = 6,
      photoList = '';
    
      for (var i=0;i<getPhotoCnt;i++) {
        var
        j = 0,
        repFlg = 0,
        fbPhoto = '';

        var imgCnt = json.data[i].images.length;
      
        while (j < imgCnt) {
          if (repFlg) {
            if ((json.data[i].images[j].width > 200) && (json.data[i].images[j].width < 400)) {
              fbPhoto = '<a target="_blank" href="' + json.data[i].images[j].source + '"><figure style="background-image: url(' + json.data[i].images[j].source + ');"></figure></a>';
              j = imgCnt;
            } else {
              j++;
            }
          } else {
           
            if ((json.data[i].images[j].width > 200) && (json.data[i].images[j].width < 800) && (json.data[i].images[j].height > 200)) {
              fbPhoto = '<a target="_blank" href="' + json.data[i].images[j].source + '"><figure style="background-image: url(' + json.data[i].images[j].source + ');"></figure></a>';
              j = imgCnt;
            } else {
              j++;
            }
            
            if ((j === imgCnt) && (fbPhoto === '')) {
              repFlg = 1;
              j = 0;
            }
          }
        }
        
        if (fbPhoto === '') {
          fbPhoto = '<a target="_blank" href="' + json.data[i].images[0].source + '"><figure style="background-image: url(' + json.data[i].images[0].source + ');"></figure></a>';
        }
        photoList += fbPhoto;
      }
    
      $('#galeria').append(photoList);

    });
  };getFaceBookpic();
});