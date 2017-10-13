$(function(){


var $script   = $('#script');
var globalId = JSON.parse($script.attr('team_id')); // phpのdata属性から取得する
var missionId = JSON.parse($script.attr('mission_id')); // phpのdata属性から取得する
var userName = $('input:hidden[name="userId"]').val(); // phpのdata属性から取得する
var goalDis = JSON.parse($script.attr('m_distance')); // phpのdata属性から取得する
var userImg = $('input:hidden[name="userImg"]').val();

var globalTime = JSON.parse($script.attr('time_limit')); // phpのdata属性から取得する
var dateTime = JSON.parse($script.attr('m_datetime')); // phpのdata属性から取得する
    init();

function init() {

// Initialize Firebase
    var config = {
        apiKey: "AIzaSyBYXx2f0k4aeGJkOAyBicNobzoUbTc-Hy0",
        authDomain: "bukazoo-1580d.firebaseapp.com",
        databaseURL: "https://bukazoo-1580d.firebaseio.com",
        projectId: "bukazoo-1580d",
        storageBucket: "bukazoo-1580d.appspot.com",
        messagingSenderId: "408874120593"
    };
    firebase.initializeApp(config);

    createMission();
    postNewChat();
    readOtherUser();

}

var timer;

function countDownTime(){
    var ref = createDB(globalId);

    // console.log(firebase.database.ServerValue);
    ref = ref.child('/mission/' + missionId);

    var toInt = parseInt(globalTime,10);
    var countSec = 60;

    timer = setInterval(function(){

        countSec--;
        var time = toHms(toInt,countSec);
        if(countSec == 0){
            countSec = 60;
            toInt--;
        }


    },1000);

}

function shearTime(){
    var ref = createDB(globalId);
    ref = ref.child('/mission/' + missionId);

    ref.on("child_changed",function(snap){

    });

}

function toHms(t,sec) {
    var hms = "";

    var m = t % 3600 | 0;
    var s = sec % 60;


    if (m != -1) {
        hms = m + ":" + padZero(s) + "秒";
    } else {
        hms = (s - sec) + "秒";
    }

    if(m == 0 && s == 00){
        clearInterval(timer);
    }

    return hms;

    function padZero(v) {
        if (v < 10) {
            return "0" + v;
        } else {
            return v;
        }
    }
}

countDownTime();

////////////////////////////////////////////////

function createDB(bu_id){
    var ref = firebase.database().ref();

    ref = ref.child(bu_id);

    if(typeof console !== 'undefined'){
        console.log('Firebase data: ', ref.toString());
    }



    return ref;

}

function createMission(){
    var ref = createDB(globalId);
    var infoDis = $(".wrap-info-distance").find("span");
    var infoGoal = $(".wrap-info-goal").find("span");
    var infoTimes = $(".wrap-info-times").find("span");
    var me = $("#each-person-now").find("li");
    var pb = $('.progress-bar');
    var rankMe = $(".ranking-dis-me").find("span");

    var count = 0;
    setInterval(function(){

        // count += 1;

        var dis = distan();

        // dis += count;
        moment.locale('ja');
        var timeLimit = globalTime;
        var endTime = moment(dateTime).add(timeLimit, 'minutes').format('YYYY-MM-DD HH:mm:ss');
        var eachTime = moment().format('YYYY-MM-DD HH:mm:ss');
        var rawtimeCount = moment(endTime).diff(moment(eachTime));

        function millisToMinutesAndSeconds (milliseconds) {
            var duration = moment.duration(milliseconds);
            var seconds = duration.seconds();
            seconds = (seconds < 10) ? "0" + seconds : seconds;

            return duration.minutes() + ":" + seconds;
        };
        var timeCount = millisToMinutesAndSeconds(rawtimeCount);
        var temp = (dis * 1000) / (goalDis * 1000);
        var amount = temp * 100;
        amount = amount.toFixed(0);
        // ref.child("/mission/"  + missionId + "/member/" + userName).set({
        //     distance : dis,
        //     disPer : amount + "%",
        //     userImg : userImg,
        //     user : userName,
        //     time : timeCount
        // });

        pb.attr({
            style : "width:" + amount + "%",
        });

        infoDis.text(dis);
        infoGoal.text(goalDis);
        
        pb.text(amount + "%");
        me.css({
            left : amount + "%"
        });
        rankMe.text(dis);
        

        ref.child("/mission/" + missionId + "/member/" + userName).once("value").then(function(snapshot){
            if(snapshot.exists()){
                var time =snapshot.val().time;
                infoTimes.text(time);
                if(String(time)=="0:00"){
                    $(".ranking-dis-me").html("TIME UP");
                    $('#timeoutModal').modal('show');
                    $('#timeoutModal').on('hidden.bs.modal', function () {
                        $('html').fadeOut(1000);
                        setTimeout(function(){
                            window.location.href = "/mypage/";
                        },1000);
                    });
                    
                };
            };
        });
        var stat = "";
        if(amount==100){
            var stat = "clear";
            $(".ranking-dis-me").eq(0).html("MISSION CLEAR!!!");
            $('#missionclearModal').modal('show');
            $('#missionclearModal').on('hidden.bs.modal', function () {
                $('html').fadeOut(1000);
                setTimeout(function(){
                    window.location.href = "/mypage/";
                },1000);
            });
        };
        // ref.child("/mission/"  + missionId + "/member/" + userName).set({
        //     status : stat
        // });
        ref.child("/mission/"  + missionId + "/member/" + userName).set({
            distance : dis,
            disPer : amount + "%",
            userImg : userImg,
            user : userName,
            time : timeCount,
            status : stat
        });

    },1000);

}

function readOtherUser(){
    var ref = createDB(globalId);
    var ranking = $(".ranking-lists");
    var eachPerson = $("#each-person-now").find("ul");

    ref = ref.child('/mission/' + missionId + "/member/");

    var arr = [];

    ref.on("value",function(snapshot){
        snapshot.forEach(function(childData){

            if(childData.val().user === userName){
                return false;
            }

            if(_.contains(arr, childData.val().user)){
                eachPerson.find('.' + childData.val().user).css({
                    left : childData.val().disPer
                });

                ranking.find('.' + childData.val().user).find("span").text(childData.val().distance);


            }else if(childData.val().user !== undefined){

                arr.push(childData.val().user);
                var html = "";

                html += '<li class="' + childData.val().user  +  '">';
                html += '<div class="each-wrap-person">';
                html += '<div class="each-bar-imgs">';
                html += '<img src="/mypage/img/' + childData.val().userImg + '">';
                html += '</div>';
                html += '<div class="each-bar"></div>';
                html += '</div></li>';

                eachPerson.append(html);

                var rank = "";

                rank += '<li class="ranking-each-person ' + childData.val().user + '">';
                rank += '<div class="ranking-user-img">';
                rank += '<img src="/mypage/img/' + childData.val().userImg + '" alt="">';
                rank += '</div>';
                rank += '<ul>';
                rank += '<li>' + childData.val().user + '</li>';
                if(childData.val().status ==""){
                    rank += '<li class="ranking-dis-me">走った距離:<span>' + childData.val().distance + '</span>km</li>';
                }else if(childData.val().status =="clear"){
                    rank += '<li class="ranking-dis-me">MISSION CLEAR!!</span>km</li>';
                };

                ranking.append(rank);

                return false;
            }

        });

    });
}


function settingDis(){
    var per = goalDis / 5;
    var wrapInfoGoal = $(".wrap-info-goal").find("span");
    var sep = $("#wrap-distance-info").find("li").find("p").find("span");

    wrapInfoGoal.text(goalDis);
    for(var i = 0; i < 5; i++){

        if(i == 0 || i == 5){
            continue;
        }
        var temp = per * i;
        var changeTemp = temp.toFixed(1);
        sep.eq(i - 1).text(changeTemp);
    }
}
    settingDis();

//---------------------------------------------------------
//チャット機能
//---------------------------------------------------------

$(document).on("click","#submit-btn",function(){
    var text = $("#chat-textarea").val();
    var name = userName;
    writeNewPost(text,name);
});

function writeNewPost(text,name) {
    // Get a key for a new Post.
    var newPostKey = createDB(globalId);
    newPostKey.child('posts').push({
        authorText: text,
        authorName : name,
        authorImg : userImg
    });
}

// チャットに書き込まれた値を受取り、反映させる
function postNewChat(){
    var NEWPOSTREF = createDB(globalId);
    var chat = $(".modal-chat").find("ul");
    var enterText = $("#chat-textarea");

    NEWPOSTREF = NEWPOSTREF.child('posts');

    NEWPOSTREF.on("child_added",function(data){
        var v    = data.val();
        var k    = data.key;
        var html = "";

        html += '<li class="chat-post clearfix">';
        html += '<div class="chat-post-pic">';
        html += '<img src="/mypage/img/' + v.authorImg + '" alt="">';
        html += '</div>';
        html += '<div class="chat-texts-area">';
        html += '<p class="chat-post-text">';
        html += v.authorText;
        html += '</p>';
        html += '<p class="chat-post-name">';
        html += v.authorName;
        html += '</p>';
        html += '</div>';
        html += '</li>';


        chat.append(html);
        enterText.val("");

    });
}




});