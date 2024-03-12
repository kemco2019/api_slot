(function (global) {
    "use strict";

    /* スロットのリール回転速度(実行毎秒数) */
    var sec = 100;

    /* スロットのリール情報
     ・スロットのリールelement
     ・スロットのリール停止フラグ
     ・スロットのリール回転数
     */
    var $reels       = [],
        stopReelFlag = [],
        reelCounts   = [];

    /* 位置情報 */
    var slotFrameHeight     = 0,
        slotReelsHeight     = 0,
        slotReelItemHeight  = 0,
        slotReelStart       = 0,
        slotReelStartHeight = 0;

    /* スロット */
    var Slot = {
        /* 初期化処理 */
        init: function init() {
            $reels[0] = $reels[1] = $reels[2] = null;
            stopReelFlag[0] = stopReelFlag[1] = stopReelFlag[2] = false;
            reelCounts[0] = reelCounts[1] = reelCounts[2] = 0;
        },
        /* スタートボタンのクリックイベント */
        start: function () {
            for (var index = 0; index<3; index++) {
                Slot.animation(index);
            }
        },
        /**
         * ストップボタンのクリックイベント
         */
        stop: function (index) {
            stopReelFlag[index] = true;
            if (stopReelFlag[0] && stopReelFlag[1] && stopReelFlag[2]) {
                // 全リール停止したらリセットボタンを押下できるようにする
                $('.btn-reset').attr('disabled', false);
            }
        },
        /* 位置情報の初期化処理 */
        resetLocationInfo: function () {
            slotFrameHeight    = $('.slot-frame').outerHeight();
            slotReelsHeight    = $('.reels').eq(0).outerHeight();
            slotReelItemHeight = $('.reel').eq(0).outerHeight();
            slotReelStart      = 5 - 2;
            // リールの上下は、半分だけ表示させるための位置調整
            slotReelStartHeight = -slotReelsHeight;
            slotReelStartHeight = slotReelStartHeight + slotFrameHeight + ((slotReelItemHeight * 3 / 2) - (slotFrameHeight / 2));

            $('.reels').css({
                'top':slotReelStartHeight 
            });
        },
        /* スロットの回転アニメーション */
        animation: function (index) {
            console.log('アニメーション', '開始', index);
            if (reelCounts[index] >= 5) {
                reelCounts[index] = 0;
            }

            console.log('slotReelStartHeight', slotReelStartHeight);
            console.log('reelCounts[index]', reelCounts[index]);
            console.log('slotReelsHeight', slotReelsHeight);
            console.log('top', slotReelStartHeight + (reelCounts[index] * slotReelItemHeight));

            $('.reels').eq(index).animate({
                'top': slotReelStartHeight + (reelCounts[index] * slotReelItemHeight)
            }, {
                duration: sec,
                easing: 'linear',
                complete: function () {
                    console.log('アニメーション', '完了', index, reelCounts[index]);
                    if (stopReelFlag[index]) {
                        console.log('アニメーション', 'ストップ', index, reelCounts[index]);
                        return ;
                    }
                    // 移動階数をカウント
                    reelCounts[index]++;
                    // スロット回転のアニメーションを実行する
                    Slot.animation(index);
                }
            });
        },
    };

    global.Slot = Slot;

})((this || 0).self || global);

/* 読み込み後 */
$(document).ready(function () {

    /* スロットの初期化処理を実行 */
    Slot.init();
    Slot.resetLocationInfo();

    /* スタートボタンのクリックイベント */
    $('.btn-start').click(function () {
        // スタートボタンを押せないようにする
        $(this).attr('disabled', true);
        // スロットの回転を開始
        Slot.start();
        // ストップボタンを押せるようにする
        $('.btn-stop').attr('disabled', false);
    });

    /* リセットボタンのクリックイベント */
    $('.btn-reset').click(function () {
        // リセットボタンを押せないようにする
        $(this).attr('disabled', true);
        // スタートボタンを押せるようにする
        $('.btn-start').attr('disabled', false);
        // ストップボタンを押せないようにする
        $('.btn-stop').attr('disabled', true);
        // スロットのリール情報を初期化
        Slot.init();
    });

    /* ストップボタンのクリックイベント */
    $('.btn-stop').click(function () {
        // ストップボタンを押せないようにする
        $(this).attr('disabled', true);
        // レールの回転を停止
        Slot.stop($(this).attr('data-val'));
    });

});