$(function(){
  'use strict';
  var getFaceBookpic = function() {
  /*************************************************************
  * Get json
  **************************************************************/
    $.getJSON('https://graph.facebook.com/1623296364610170/photos/?fields=images&access_token=EAADtrhgW99cBAAFERQWrp1iSCKZBKZBNUDZAFDoDtPsXHGfZAccDWFjNnnlh1lWLAZCBsIqXrKWYOqKtSrZBZBTFYcfWwy1zBpP6MT8nyPiu5qqBxfffSafbaulZAIAKvzY7ZAWOI4eNUHRjweuyUzzW8V5lp82uHUbiCQuZBNoSM9dwZDZD', function(json){
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