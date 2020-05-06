/**
 * jQuery scripts... :(
 */

(function ($) {
  'use strict';

  let hash = decodeURI(window.location.hash.replace('#', ''));
  let hashes = [
    'access_recovery', 'requisites', 'docs', 'alarm', 'clinic_alarm', 'pay', 'pay_edit', 'photo preview', 'changes'
  ];

  // функция открытия окна
  function openPopup(hash) {
    $('html').css({ 'overflow-y': 'hidden', 'overflow-x': 'hidden' });

    $('.overlay').fadeIn(300, function () {
      $('.popup, .popup .overlay').show();
      $(hash).css('display', 'flex').animate({ opacity: 1 }, 300);
    })
  }

  // функция закрытия окна
  function closePopup() {
    $('.modal').animate({ opacity: 0 }, 300, function () {
      history.pushState('', document.title, window.location.pathname);

      $('.popup, .popup .overlay, .popup .modal').hide();
      $('.overlay').fadeOut(300);
      $('html').css('overflow-y', 'visible');
    })
  }

  // открывает окно
  $('.open-modal').on('click', function (event) {
    event.preventDefault();

    let hash = $(this).attr('href');

    openPopup(hash);
  });

  // ..при загрузке страницы
  $.each(hashes, function (index, value) {
    if (hash === value.toString()) {
      openPopup('#' + hash);
    }
  });

  // закрывает окно
  $('.close-modal').on('click', function (event) {
    event.preventDefault();

    closePopup();
  });

  // ..при нажатии на клавишу escape
  $('body').keydown(function (event) {
    if (event.keyCode === 27) {
      closePopup();
    }
  });
}(jQuery));

(function ($) {
  'use strict';

  // стилизация select
  let select_initial_value = '';
  let current_select = '';
  let suggest_selected = 0;

  $(window).one('load', function () {
    // показываем варианты для выбора при клике на поле
    $('.select_box').focus(function (event) {
      current_select = $(this).attr('id');

      $('.select_options[data-for="' + current_select + '"]').css({ 'display': 'flex' });

      event.stopPropagation();
    });

    // обрабатываем клик по вариантам
    $('.select_options').on('click', '.option', function () {
      current_select = $(this).parent('.select_options').attr('data-for');

      // обновляем значение поля select и идентификатор в скрытом поле
      $('#' + current_select).val($(this).text());
      $('#' + current_select).change();
      $('#' + current_select + '-id').val($(this).attr('data-id'));
      $('#' + current_select + '-id').change();

      // прячем варианты
      $('.select_options').fadeOut(300);
    });

    // прячем варианты
    $(document).on('click', function (event) {
      if (!$('.select_box, .select_options').is(event.target)) {
        $('.select_options').fadeOut(300)
      }
    });

    // считываем нажатия клавиш
    $('.select_box').keyup(function (up) {
      // задаём действия при нажатии клавиш
      switch (up.keyCode) {
        // игнорируем нажатия клавиш
        case 13: // enter
        case 27: // escape
        case 38: // стрелка вверх
        case 40: // стрелка вниз
          break;
      }
    });

    // считывает нажатия клавиш, после вывода вариантов
    $('.select_box').keydown(function (down) {
      // определяет идентификатор текущего элемента
      current_select = $(this).attr('id');

      // задаём действия при нажатии клавиш
      switch (down.keyCode) {
        // прячем вырианты при нажатии клавиш
        case 13:
        case 27:
          $('.select_options').hide();
          $(this).blur();
          break;

        // переходим вверх/вниз по вариантам
        case 38:
        case 40:
          down.preventDefault();
          // выбираем пункт
          key_activate(down.keyCode - 39);
          break;
      }
    });

    // обрабатываем нажатия клавиш
    function key_activate(num) {
      $('.select_options .option').eq(suggest_selected - 1).removeClass('active');

      if (num === 1) {
        suggest_selected++;
      } else if (num === -1 && suggest_selected > 0) {
        suggest_selected--;
      }

      if (suggest_selected > 0) {
        $('.select_options .option').eq(suggest_selected - 1).addClass('active');

        // ставим текст в input и идентификатор в скрытое поле
        $('#' + current_select).val($('.select_options .option').eq(suggest_selected - 1).text());
        $('#' + current_select + '-id')
          .val($('.select_options[data-for="' + current_select + '"] .option.active').attr('data-id'));
      } else {
        $('.select_box').val(select_initial_value);
      }
    }
  });
}(jQuery));