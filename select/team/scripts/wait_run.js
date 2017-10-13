$(function(){


var globalId = $('input:hidden[name="teamId"]').val();
var missionId = $('input:hidden[name="missionId"]').val();
var userName = $('input:hidden[name="userId"]').val();
var userImg = $('input:hidden[name="userImg"]').val();
var mDatetime = $('input:hidden[name="mDatetime"]').val();

// var globalTime = JSON.parse($script.attr('time_limit')); // phpのdata属性から取得する

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

    addFire_user();
    postNewChat();
    readOtherUser();
    createMission();
}

// var timer;
//
// function countDownTime(){
//     var ref = createDB(globalId);
//
//     // console.log(firebase.database.ServerValue);
//     ref = ref.child('/mission/' + missionId);
//
//     var toInt = parseInt(globalTime,10);
//     var countSec = 60;
//
//     timer = setInterval(function(){
//
//         countSec--;
//         var time = toHms(toInt,countSec);
//         if(countSec == 0){
//             countSec = 60;
//             toInt--;
//         }
//
//
//     },1000);
//
// }
//
// function shearTime(){
//     var ref = createDB(globalId);
//     ref = ref.child('/mission/' + missionId);
//
//     ref.on("child_changeed",function(snap){
//
//     });
//
//
// }
//
// function toHms(t,sec) {
//     var hms = "";
//
//     var m = t % 3600 | 0;
//     var s = sec % 60;
//
//
//     if (m != -1) {
//         hms = m + ":" + padZero(s) + "秒";
//     } else {
//         hms = (s - sec) + "秒";
//     }
//
//     if(m == 0 && s == 00){
//         clearInterval(timer);
//     }
//
//     return hms;
//
//     function padZero(v) {
//         if (v < 10) {
//             return "0" + v;
//         } else {
//             return v;
//         }
//     }
// }
//
// countDownTime();

////////////////////////////////////////////////

function createDB(bu_id){
    var ref = firebase.database().ref();

    ref = ref.child(bu_id);

    if(typeof console !== 'undefined'){
        console.log('Firebase data: ', ref.toString());
    }

    return ref;
}

function addFire_user(){
    var ref = createDB(globalId);
    var lists = $(".member-lists");
    var html = "";

        ref.child("/mission/"  + missionId + "/member/" + userName).set({
            userImg : userImg,
            user : userName
        });

    html += '<li>';
    html += '<div class="member-user-img">';
    html += '<img src="/mypage/img/' + userImg + '" alt="">';
    html += '</div>';
    html += '<p class="member-user-name">';
    html += userName;
    html += '</p>';
    html += '</li>';

    lists.append(html);
}

function readOtherUser(){
    var ref = createDB(globalId);
    var lists = $(".member-lists");
    var mp = $(".mp").find("span");
    var html = "";

    ref = ref.child('/mission/' + missionId + "/member/");

    var arr = [];
    var flag = true;

    ref.on("value",function(snapshot){

        snapshot.forEach(function(childData){


            if(childData.val().user === userName && flag == true){
                arr.push(childData.val().user);
                mp.text(arr.length);
                flag = false;
                return false;
            }

            if(_.contains(arr, childData.val().user)){

            }else if(childData.val().user !== undefined){
                arr.push(childData.val().user);
                html += '<li>';
                html += '<div class="member-user-img">';
                html += '<img src="/mypage/img/' + childData.val().userImg + '" alt="">';
                html += '</div>';
                html += '<p class="member-user-name">';
                html += childData.val().user;
                html += '</p>';
                html += '</li>';

                lists.append(html);
            }

            mp.text(arr.length);


        });

    });

}

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
        authorName : name
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

        html += "<li>";
        html += v.authorText;
        html += "</li>";

        chat.append(html);
        enterText.val("");

    });
}

function createMission(){
    // var valid_flg = 0;
    var infoTimes = $(".timecountdown").find("span");
    var ref = createDB(globalId);
    setInterval(function(){
        moment.locale('ja');
        var timeLimit = mDatetime;
        var eachTime = moment().format('YYYY-MM-DD HH:mm:ss');
        var rawtimeCount = moment(timeLimit).diff(moment(eachTime));

        function millisToMinutesAndSeconds (milliseconds) {
            var duration = moment.duration(milliseconds);
            var seconds = duration.seconds();
            seconds = (seconds < 10) ? "0" + seconds : seconds;

            return duration.minutes() + ":" + seconds;
        };
        var entrycountdown = millisToMinutesAndSeconds(rawtimeCount);
        ref.child("/mission/"  + missionId + "/member/" + userName).set({
            entrytime : entrycountdown
        });
        ref.child("/mission/" + missionId + "/member/" + userName).once("value").then(function(snapshot){
            if(snapshot.exists()){
                var time =snapshot.val().entrytime;
                infoTimes.text(time);
                if(rawtimeCount<=0){
                    document.getElementById("start_mission").disabled = "";
                };
            };
        });
    },1000);
};


});