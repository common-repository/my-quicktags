edButtons[edButtons.length] = 
new edButton('ed_class_html'
,'HTML Encoder'
,'[html_encoded'
,']'
,'r'
);

edButtons[edButtons.length] = 
new edButton('ed_class_mp3'
,'MP3 Embed'
,'[mp3_embed'
,']'
,'s'
);

function edShowButton(button, i) {
if (button.id == 'ed_img') {
document.write('<input type="button" id="' + button.id + '" accesskey="' + button.access + '" class="ed_button" onclick="edInsertImage(edCanvas);" value="' + button.display + '" />');
}
else if (button.id == 'ed_link') {
document.write('<input type="button" id="' + button.id + '" accesskey="' + button.access + '" class="ed_button" onclick="edInsertLink(edCanvas, ' + i + ');" value="' + button.display + '" />');
}
else if (button.id == 'ed_class_html') {
document.write('<input type="button" id="' + button.id + '" accesskey="' + button.access + '" class="ed_button" onclick="edInsertClassHtml(edCanvas, ' + i + ');" value="' + button.display + '" />');
}
else if (button.id == 'ed_class_mp3') {
document.write('<input type="button" id="' + button.id + '" accesskey="' + button.access + '" class="ed_button" onclick="edInsertClassMp3(edCanvas, ' + i + ');" value="' + button.display + '" />');
}
else {
document.write('<input type="button" id="' + button.id + '" accesskey="' + button.access + '" class="ed_button" onclick="edInsertTag(edCanvas, ' + i + ');" value="' + button.display + '"  />');
}
}

/**********
[mp3_embed mp3_aligns="center" aps="yes" colors="#1F55B2" nums="4" mp3wids="250" mp3highs="200" blog_plyrs="3" id="2" playlistfolder="yourfolder" shuffle="yes" ]
************/

function edInsertClassHtml(myField, i, defaultValue) 
  { if (!defaultValue) 
    { defaultValue = '';
    } 
    if (!edCheckOpenTags(i)) 
    { edInserthtmlcode(myField);
    }
    else 
    { edInsertTag(myField, i);v 
    }
  }
function edInsertClassMp3(myField, i, defaultValue) 
  { if (!defaultValue) 
    { defaultValue = '';
    }
    if (!edCheckOpenTags(i)) 
    { edInsertmp3(myField);
    }
    else 
    { edInsertTag(myField, i);v 
    }
  }


function edInserthtmlcode(b){var a=prompt("Please enter the code to be encoded","Insert Code");
if(a){a='[html_encoded]'+encode_entities(a)+'[/html_encoded]';}edInsertContent(b,a)
}


function edInsertmp3(b){var a=prompt("Please enter the blog player that you want 1-4","1");
if(a&&a==1||a==4){a='[mp3_embed blog_plyrs="'+a+'" playlst="'+prompt("Enter URL for single song","http://www.yourdomain.com/yoursong.mp3")+'"  mp3_aligns="'+prompt("Align Player","center")+'" aps="'+prompt("Auto Play","no")+'" colors="'+prompt("Enter the color that you want","#1F55B2")+'" nums="'+prompt("Enter the type of blog player you want(1-5)","4")+'" mp3wids="'+prompt("Enter the width of the player","250")+'" mp3highs="'+prompt("Enter the height of the player","200")+'" id="'+prompt("Enter the id of the player if more than of the same","1")+'" shuffle="'+prompt("Shuffle songs (yes/no)","no")+'" transparent="'+prompt("Transparent (yes/no)","yes")+'" pop_mp3="'+prompt("Show pop-up button under player (yes/no)","no")+'"]';}
else if(a&&a==2||a==3){a='[mp3_embed blog_plyrs="'+a+'" mp3_aligns="'+prompt("Align Player","center")+'" aps="'+prompt("Auto Play","no")+'" colors="'+prompt("Enter the color that you want","#1F55B2")+'" nums="'+prompt("Enter the type of blog player you want(1-5)","4")+'" mp3wids="'+prompt("Enter the width of the player","250")+'" mp3highs="'+prompt("Enter the height of the player","200")+'" id="'+prompt("Enter the id of the player if more than of the same","1")+'" playlistfolder="'+prompt("Enter the folder that you want the music to come from","mp3")+'" shuffle="'+prompt("Shuffle songs (yes/no)","no")+'" transparent="'+prompt("Transparent (yes/no)","yes")+'" show="'+prompt("Show numbers next to title? (yes/no)","yes")+'" pop_mp3="'+prompt("Show pop-up button under player (yes/no)","no")+'"]';}edInsertContent(b,a)
}

function $(id){ return document.getElementById(id) }

function encode_entities(s){
  var result = '';
  for (var i = 0; i < s.length; i++){
    var c = s.charAt(i);
    result += {'<':'&#60;', '>':'&#62;', '&':'&#38;', '\"':'&#34;', '\'':'&#39;', '-':'&#45;', '/':'&#47;', '=':'&#61;', '!':'&#33;', '(':'&#40;', ')':'&#41;', '[':'&#91;', ']':'&#93;', '{':'&#123;', '}':'&#125;', '\n':'&#13;'}[c] || c;
  }
  return result;
}