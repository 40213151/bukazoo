      let GRAVITY_MIN = 9.8;
      let GRAVITY_MAX = 17.00;
      // 歩数
      let _step = 0;
      // 現在歩いているかどうか
      let _isStep = false;

      let TimingSec = 0;
      let prev_sec = 0;
      let dif_sec = 0;
      let runwalktime = 38;
      let distance = 0;
      let walkwidth = 0.82;
      let runwidth = 1.13;
      let judge = "";

          let PassSec = 0;   // カウンタのリセット
          PassageID = setInterval('showPassage()',10);
          function showPassage(){
          PassSec++;   // カウントアップ
          // var msg = PassSec + "/10msecが経過しました。";   // 表示文作成
          // document.getElementById("PassageArea").innerHTML = msg;   // 表示更新
          };

      (function() {
        window.addEventListener("devicemotion", function(e){

          //傾き(重力加速度)
          var acc_g = e.accelerationIncludingGravity;
          var gx = obj2NumberFix(acc_g.x, 5);
          var gy = obj2NumberFix(acc_g.y, 5);
          var gz = obj2NumberFix(acc_g.z, 5);

          var acc = Math.sqrt(acc_g.x*acc_g.x + acc_g.y*acc_g.y + acc_g.z*acc_g.z);
          
          if (_isStep) {
              // 歩行中にしきい値よりも低ければ一歩とみなす
              if (acc < GRAVITY_MIN) {
                  // _step++;
                  _isStep = false;
              }
          } else {
              // しきい値よりも大きければ歩いているとみなす
              if (acc > GRAVITY_MAX) {
                  _isStep = true;
                  _step++;
                  prev_sec = TimingSec;
                  TimingSec = PassSec;
                  dif_sec = TimingSec - prev_sec;
                  if(dif_sec > runwalktime){
                      distance = distance + walkwidth;
                      judge = "walk";
                  }else if(dif_sec <= runwalktime){
                      distance = distance + runwidth;
                      judge = "run";
                  }
              }

          }
          // document.getElementById("step").innerHTML = _step + "歩 NOW: " + TimingSec + "/10msec時点 PAST: " + prev_sec + "/10msec 時間差分:" + dif_sec + judge +" 総合走行距離" + distance;




          // function
          function obj2NumberFix(obj, fix_deg){
            return Number(obj).toFixed(fix_deg);//第一引数で型変換を行ってる。第二引数で固定少数点表記の桁数を指定する。
          }

          // function print1(id, value){
          //   var id_obj = document.getElementById(id);
          //   id_obj.innerHTML = value;
          // }
          //
        });
      })();


      function distan(){
          let km_distance=0;
          let smpl_distance = Math.floor(distance/10);
          let raw_km_distance = smpl_distance / 100;
          km_distance = raw_km_distance.toFixed(2);
          return km_distance;
      };

