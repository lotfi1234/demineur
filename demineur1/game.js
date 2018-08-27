var vm;
vm = new Vue({
    el: '#tuto',
    data: {
        time: {
            secondes: 0
        },
        first:true,
        btnPlay: 'Pause',
active:false,
        etat: {
            stop: true,
            play: false
        },

    },

    methods: {
        play: function () {
            chronoStart();
            this.show();
        },
        stop: function () {
            chronoStop();
            this.hide();
        },
        hide:function () {
            position();
        },
        show:function () {
            continu();
        }
    }
});
var totalSecondes = 0;
var timer;
var tab=[];

chronoStart = function() {
    timer = setInterval(function() {
        vm.time.secondes ++;totalSecondes=vm.time.secondes;
    }, 1000);

    setEtat(false, true);
};

chronoStop = function() {
    clearInterval(timer);
    setEtat(true, false);
};
position=function(){
    tab=[];
  for (i=0;i<w;i++){
      tab[i]=[];
      for (j=0;j<h;j++){
          if(document.getElementById(i+"-"+j).innerHTML.length>0){
              document.getElementById(i+"-"+j).style.background="lightgray";
              document.getElementById(i+"-"+j).innerHTML=" ";
              tab[i][j]=1;

          }else
              if (document.getElementById(i+"-"+j).innerHTML.length==0 && document.getElementById(i+"-"+j).style.background=="white"){
                  document.getElementById(i+"-"+j).style.background="lightgray";
                  tab[i][j]=1;
              }
      }
  }
};
continu=function(){
  for (i=0;i<w;i++) {
      for (j = 0; j < h; j++) {
          if (tab[i][j] == 1) {
              document.getElementById(i+"-"+j).style.background = "white";
              document.getElementById(i+"-"+j).innerHTML = m[i][j];
          }
      }
  }
};
setEtat = function(play, stop) {
    vm.etat.play = play;
    vm.etat.stop = stop;
};

