/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/modal.js ***!
  \*******************************/
$(function () {
  // 変数に要素を入れる
  var open = $('.modal-open-import'),
      close = $('.modal-close-import'),
      container = $('.modal-container-import'); //開くボタンをクリックしたらモーダルを表示する

  open.on('click', function () {
    container.addClass('active');
    return false;
  }); //閉じるボタンをクリックしたらモーダルを閉じる

  close.on('click', function () {
    container.removeClass('active');
  }); //モーダルの外側をクリックしたらモーダルを閉じる

  $(document).on('click', function (e) {
    if (!$(e.target).closest('.modal-body-import').length) {
      container.removeClass('active');
    }
  });
});
$(function () {
  // 変数に要素を入れる
  var open = $('.modal-open-export'),
      close = $('.modal-close-export'),
      container = $('.modal-container-export'); //開くボタンをクリックしたらモーダルを表示する

  open.on('click', function () {
    container.addClass('active');
    return false;
  }); //閉じるボタンをクリックしたらモーダルを閉じる

  close.on('click', function () {
    container.removeClass('active');
  }); //モーダルの外側をクリックしたらモーダルを閉じる

  $(document).on('click', function (e) {
    if (!$(e.target).closest('.modal-body-export').length) {
      container.removeClass('active');
    }
  });
});
/******/ })()
;