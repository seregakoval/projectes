(function($){
    // количество секунд в каждом блоке времени
    var days        = 24*60*60,
        hours        = 60*60,
        minutes        = 60;
    // создание плагина
    $.fn.countdown = function(prop){
        var options = $.extend({
            callback        : function(){},
            timestamp        : 0
        },prop);
        var left, d, h, m, s, positions;
        // Инициализация таймера
        positions = this.find('.position');
        (function tick(){
            // Оставьшееся время
            left = Math.floor((options.timestamp - (new Date())) / 1000);
            if(left < 0){
                left = 0;
            }
            // Количество оставшихся дней
            d = Math.floor(left / days);
            //updateDuo(0, 1, d);
            left -= d*days;
            // Количество оставшихся часов
            h = Math.floor(left / hours);
            //updateDuo(2, 3, h);
            left -= h*hours;
            // Количество оставшихся минут
            m = Math.floor(left / minutes);
            //updateDuo(4, 5, m);
            left -= m*minutes;
            // Количество оставшихся секунд
            s = left;
            //updateDuo(6, 7, s);
            // Callback
            options.callback(d, h, m, s);
            // Автоматический вызов этой функции каждую секунду
            setTimeout(tick, 1000);
        })();
        return this;
    };
    /* Две вспомогательные функции, которые мы создали ранее */
})(jQuery);