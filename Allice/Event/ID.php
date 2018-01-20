<?php


namespace Allice\Event;

class ID {
    const CORE_ERROR = 999; //ошибки уровня ядра
    const ERROR = 990; // ошибки от try/catch
    const LOG = 900; // пользовательский лог

    const SYSTEM_LOG = 910; // системный лог работы ядра
    const SYSTEM_CORE_LOG = 998; // rопия лога ошибок уровня ядра - вывод в class logg

    const DOMAIN_FOUND = 100;
    const ROUTE_FOUND = 200;
    const MODEL_FOUND = 300;
    const MODEL_RUN = 350;
    const RENDER_VIEW  = 3;
    const VIEW_SEND = 4;
};

?>